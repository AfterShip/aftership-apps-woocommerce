#!/bin/bash

svn_url="http://plugins.svn.wordpress.org/aftership-woocommerce-tracking"
git_url="git@github.com:AfterShip/aftership-apps-woocommerce.git"

git_tmp_dir=$(mktemp -d)
git clone $git_url $git_tmp_dir

# get version number from readme.txt
version=$(sed -n '7p' "$git_tmp_dir/readme.txt" | cut -c 13-)

echo "Version number is $version"

build_dir="../build/$version"

# if build directory exists, remove it
if [ -d "$build_dir" ]; then
    rm -rf "$build_dir"
fi

mkdir -p "$build_dir"

# move all files from git to build directory
cp "$git_tmp_dir"/aftership-woocommerce-tracking.php "$build_dir"
mkdir -p "$build_dir/assets/frontend"
mkdir -p "$build_dir/assets/frontendv2"
cp -r "$git_tmp_dir"/assets/frontend/dist "$build_dir/assets/frontend"
cp -r "$git_tmp_dir"/assets/frontendv2/dist "$build_dir/assets/frontendv2"
cp -r "$git_tmp_dir"/assets/css "$build_dir/assets"
cp -r "$git_tmp_dir"/assets/js "$build_dir/assets"
cp -r "$git_tmp_dir"/assets/images "$build_dir/assets"
cp -r "$git_tmp_dir"/assets/plugin "$build_dir/assets"
cp -r "$git_tmp_dir"/assets/*.png "$build_dir/assets"
cp -r "$git_tmp_dir"/includes "$build_dir"
cp -r "$git_tmp_dir"/templates "$build_dir"
cp -r "$git_tmp_dir"/views "$build_dir"
cp -r "$git_tmp_dir"/woo-includes "$build_dir"
cp -r "$git_tmp_dir"/aftership.php "$build_dir"
cp -r "$git_tmp_dir"/aftership-woocommerce-tracking.php "$build_dir"
cp -r "$git_tmp_dir"/readme.txt "$build_dir"

# remove git temporary directory
rm -rf "$git_tmp_dir"

# check script parameters if it want to deploy to SVN
if [ "$1" != "deploy" ]; then
    echo "Build completed. Run 'sh scripts/build.sh deploy' to deploy to SVN."
    exit 0
fi

# deploy to SVN
svn_tmp_dir=$(mktemp -d)
svn checkout $svn_url $svn_tmp_dir

# check if already deployed to svn
if [ -d "$svn_tmp_dir/tags/$version" ]; then
    echo "Version $version already exists in SVN. Please update version number in readme.txt."
    exit 1
fi

rm -rf "$svn_tmp_dir/trunk/*"
mkdir -p "$svn_tmp_dir/tags/$version"

cp -r "$build_dir/*" "$svn_tmp_dir/trunk"
cp -r "$build_dir/*" "$svn_tmp_dir/tags/$version"

cd "$svn_tmp_dir" && svn add . --force && svn ci -m "Version $version" --username aftership --force-interactive

echo "Process completed."