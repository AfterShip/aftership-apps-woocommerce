(async => {


    const couriers = require('./couriers.json');

    for (const courier of couriers) {
        if (courier.required_fields.length){
            //console.log(courier.slug + '=>' + courier.required_fields.join(','))
            console.log(courier.required_fields.join(','))
        }
    }
})()