const fs = require('fs');
const archiver = require('archiver');
const path = require('path');

(async () => {
    // 定义需要打包的目录和文件数组
    const directories = ['assets', 'includes', 'templates', 'views', 'woo-includes'];
    const files = ['aftership.php', 'aftership-woocommerce-tracking.php', 'readme.txt'];

    // 创建一个输出流，用于保存生成的 zip 文件
    const buildDir = './build';
    const build = path.join(buildDir, 'aftership-woocommerce-tracking.zip');

    // 确保目标目录存在
    if (!fs.existsSync(buildDir)) {
        fs.mkdirSync(buildDir);
    }

    if (fs.existsSync(build)) {
        fs.unlinkSync(build);
    }
    const outputZip = fs.createWriteStream(build);

    // 创建一个 archiver 实例，并设置打包类型为 zip
    const archive = archiver('zip', {
        zlib: { level: 9 } // 设置压缩级别为最高
    });

    // 将输出流连接到 archiver 实例中
    archive.pipe(outputZip);

    // 循环遍历需要打包的目录，并添加到 archiver 实例中
    directories.forEach((dir) => {
        archive.directory(dir, false);
    });

    // 循环遍历需要打包的文件，并添加到 archiver 实例中
    files.forEach((file) => {
        archive.file(file, { name: file });
    });

    // 完成打包操作
    archive.finalize();
})();