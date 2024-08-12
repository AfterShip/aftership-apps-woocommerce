'use strict';
(async () => {
    function sort_by_key(array, key)
    {
        return array.sort(function(a, b)
        {
            var x = a[key]; var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }
    const fs = require('fs');
    const axios = require('axios').default;
    // const axios = require('axios/dist/node/axios.cjs');
    const response = await axios({
        method: 'GET',
        url: 'https://couriers-data.aftershipapi.com/v1/couriers?fields=slug,required_fields_format,optional_fields_format,name,slug_group,destination_tracking_number_regex,next_courier_aliases,alias',
        headers: {
            'aftership-api-key': process.env.AM_API_KEY,
        }
    })
    const couriers = response.data.data;
    const result = [];
    couriers.forEach((courier) => {
        const required_fields = courier.required_fields_format ? courier.required_fields_format.split(':') : [];
        let parsed_required_fields = []
        for (const item of required_fields) {
            parsed_required_fields.push(`tracking_${item}`)
        }
        const temp = {
            "slug": courier.slug,
            "name": courier.name,
            "other_name": courier.alias,
            "required_fields": parsed_required_fields,
        }
        if (courier.slug === 'australia-post-api') temp.name = 'Australia Post API';
        result.push(temp);
    });
    // 增加 other 选项
    result.push({
        "slug": "other",
        "name": "other",
        "other_name": "other",
        "required_fields": [],
    })
    const jsonContent = JSON.stringify(sort_by_key(result, 'slug'), null, 2);
    console.info(jsonContent);
    fs.writeFile("couriers.json", jsonContent, 'utf8', function (err) {
        if (err) {
            console.log("An error occured while writing JSON Object to File.");
            return console.log(err);
        }
        console.log("JSON file has been saved.");
    });
})();