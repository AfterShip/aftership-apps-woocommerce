function get_couriers() {
	var data = [
		{
			"slug": "17postservice",
			"name": "17 Post Service",
			"other_name": "17PostService",
			"required_fields": []
		},
		{
			"slug": "2go",
			"name": "2GO",
			"other_name": "Negros Navigation",
			"required_fields": []
		},
		{
			"slug": "4px",
			"name": "4PX",
			"other_name": "递四方",
			"required_fields": []
		},
		{
			"slug": "4squaregroup",
			"name": "4Square Group",
			"other_name": "4 Square",
			"required_fields": []
		},
		{
			"slug": "800bestex",
			"name": "Best Express",
			"other_name": "百世汇通",
			"required_fields": []
		},
		{
			"slug": "abf",
			"name": "ABF Freight",
			"other_name": "Arkansas Best Corporation",
			"required_fields": []
		},
		{
			"slug": "abxexpress-my",
			"name": "ABX Express",
			"other_name": "ABX Express (M) Sdn Bhd",
			"required_fields": []
		},
		{
			"slug": "acscourier",
			"name": "ACS Courier",
			"other_name": "Αναζήτηση Καταστημάτων",
			"required_fields": []
		},
		{
			"slug": "aeroflash",
			"name": "Mexico AeroFlash",
			"other_name": "AeroFlash",
			"required_fields": []
		},
		{
			"slug": "air21",
			"name": "AIR21",
			"other_name": "AIR 21 PH",
			"required_fields": []
		},
		{
			"slug": "an-post",
			"name": "An Post",
			"other_name": "Ireland Post",
			"required_fields": []
		},
		{
			"slug": "apc",
			"name": "APC Postal Logistics",
			"other_name": "APC-PLI",
			"required_fields": []
		},
		{
			"slug": "apc-overnight",
			"name": "APC Overnight",
			"other_name": "The Alternative Parcels Company Limited",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "aramex",
			"name": "Aramex",
			"other_name": "ارامكس",
			"required_fields": []
		},
		{
			"slug": "arrowxl",
			"name": "Arrow XL",
			"other_name": "Yodel XL",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "asendia-de",
			"name": "Asendia Germany",
			"other_name": "Asendia De",
			"required_fields": []
		},
		{
			"slug": "asendia-uk",
			"name": "Asendia UK",
			"other_name": "Asendia United Kingdom",
			"required_fields": []
		},
		{
			"slug": "asendia-usa",
			"name": "Asendia USA",
			"other_name": "Brokers Worldwide",
			"required_fields": []
		},
		{
			"slug": "asm",
			"name": "ASM",
			"other_name": "Asm-Red",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "aupost-china",
			"name": "AuPost China",
			"other_name": "澳邮宝",
			"required_fields": []
		},
		{
			"slug": "australia-post",
			"name": "Australia Post",
			"other_name": "AusPost",
			"required_fields": []
		},
		{
			"slug": "austrian-post",
			"name": "Austrian Post (Express)",
			"other_name": "Österreichische Post AG",
			"required_fields": []
		},
		{
			"slug": "austrian-post-registered",
			"name": "Austrian Post (Registered)",
			"other_name": "Österreichische Post AG",
			"required_fields": []
		},
		{
			"slug": "belpost",
			"name": "Belpost",
			"other_name": "Belposhta, Белпочта",
			"required_fields": []
		},
		{
			"slug": "bert-fr",
			"name": "Bert Transport",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bgpost",
			"name": "Bulgarian Posts",
			"other_name": "Български пощи",
			"required_fields": []
		},
		{
			"slug": "bluedart",
			"name": "Bluedart",
			"other_name": "Blue Dart Express",
			"required_fields": []
		},
		{
			"slug": "boxc",
			"name": "BOXC",
			"other_name": "BOXC快遞",
			"required_fields": []
		},
		{
			"slug": "bpost",
			"name": "Belgium Post",
			"other_name": "bpost, Belgian Post",
			"required_fields": []
		},
		{
			"slug": "bpost-international",
			"name": "bpost international",
			"other_name": "Belgium Post International, Minipak DDU",
			"required_fields": []
		},
		{
			"slug": "brazil-correios",
			"name": "Brazil Correios",
			"other_name": "Brazilian Post",
			"required_fields": []
		},
		{
			"slug": "brt-it",
			"name": "BRT Bartolini",
			"other_name": "BRT Corriere Espresso, DPD Italy",
			"required_fields": []
		},
		{
			"slug": "cambodia-post",
			"name": "Cambodia Post",
			"other_name": "Cambodia Post",
			"required_fields": []
		},
		{
			"slug": "canada-post",
			"name": "Canada Post",
			"other_name": "Postes Canada",
			"required_fields": []
		},
		{
			"slug": "canpar",
			"name": "Canpar Courier",
			"other_name": "TransForce",
			"required_fields": []
		},
		{
			"slug": "cbl-logistica",
			"name": "CBL Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ceska-posta",
			"name": "Česká Pošta",
			"other_name": "Czech Post",
			"required_fields": []
		},
		{
			"slug": "china-ems",
			"name": "China EMS",
			"other_name": "中国邮政速递物流",
			"required_fields": []
		},
		{
			"slug": "china-post",
			"name": "China Post",
			"other_name": "中国邮政, ePacket, e-Packet",
			"required_fields": []
		},
		{
			"slug": "chronopost-france",
			"name": "Chronopost France",
			"other_name": "La Poste EMS",
			"required_fields": []
		},
		{
			"slug": "chronopost-portugal",
			"name": "Chronopost Portugal",
			"other_name": "Chronopost pt",
			"required_fields": []
		},
		{
			"slug": "citylinkexpress",
			"name": "City-Link Express",
			"other_name": "Citylink Malaysia",
			"required_fields": []
		},
		{
			"slug": "cj-gls",
			"name": "CJ GLS",
			"other_name": "CJ Korea Express, 씨제이지엘에스주식회사",
			"required_fields": []
		},
		{
			"slug": "cnexps",
			"name": "CNE Express",
			"other_name": "国际快递",
			"required_fields": []
		},
		{
			"slug": "colis-prive",
			"name": "Colis Privé",
			"other_name": "ColisPrivé",
			"required_fields": []
		},
		{
			"slug": "colissimo",
			"name": "Colissimo",
			"other_name": "Colissimo fr",
			"required_fields": []
		},
		{
			"slug": "collectplus",
			"name": "Collect+",
			"other_name": "Collect Plus UK",
			"required_fields": []
		},
		{
			"slug": "correo-argentino",
			"name": "Correo Argentino",
			"other_name": "Argentina Post",
			"required_fields": []
		},
		{
			"slug": "correos-chile",
			"name": "Correos Chile",
			"other_name": "Chile Post",
			"required_fields": []
		},
		{
			"slug": "correos-de-mexico",
			"name": "Correos de Mexico",
			"other_name": "Mexico Post",
			"required_fields": []
		},
		{
			"slug": "correosexpress",
			"name": "Correos Express",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "courier-plus",
			"name": "Courier Plus",
			"other_name": "Courier Plus",
			"required_fields": []
		},
		{
			"slug": "courierit",
			"name": "Courier IT",
			"other_name": "Courierit",
			"required_fields": []
		},
		{
			"slug": "courierpost",
			"name": "CourierPost",
			"other_name": "Express Couriers",
			"required_fields": []
		},
		{
			"slug": "couriers-please",
			"name": "Couriers Please",
			"other_name": "CouriersPlease",
			"required_fields": []
		},
		{
			"slug": "cyprus-post",
			"name": "Cyprus Post",
			"other_name": "ΚΥΠΡΙΑΚΑ ΤΑΧΥΔΡΟΜΕΙΑ",
			"required_fields": []
		},
		{
			"slug": "dachser",
			"name": "DACHSER",
			"other_name": "Azkar",
			"required_fields": []
		},
		{
			"slug": "danmark-post",
			"name": "Post Danmark",
			"other_name": "Danske Post",
			"required_fields": []
		},
		{
			"slug": "dawnwing",
			"name": "Dawn Wing",
			"other_name": "DPD Laser Express Logistics",
			"required_fields": []
		},
		{
			"slug": "dbschenker-se",
			"name": "DB Schenker Sweden",
			"other_name": "Deutsche Bahn",
			"required_fields": []
		},
		{
			"slug": "delcart-in",
			"name": "Delcart",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "delhivery",
			"name": "Delhivery",
			"other_name": "Gharpay",
			"required_fields": []
		},
		{
			"slug": "delivreeking",
			"name": "Delivree King",
			"other_name": "delivery king",
			"required_fields": []
		},
		{
			"slug": "deltec-courier",
			"name": "Deltec Courier",
			"other_name": "Deltec Interntional Courier",
			"required_fields": []
		},
		{
			"slug": "deutsch-post",
			"name": "Deutsche Post Mail",
			"other_name": "dpdhl",
			"required_fields": [
				"tracking_ship_date"
			]
		},
		{
			"slug": "dhl",
			"name": "DHL Express",
			"other_name": "DHL International",
			"required_fields": []
		},
		{
			"slug": "dhl-benelux",
			"name": "DHL Benelux",
			"other_name": "DHL TrackNet Benelux",
			"required_fields": []
		},
		{
			"slug": "dhl-deliverit",
			"name": "DHL 2-Mann-Handling",
			"other_name": "DHL Deliver IT",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "dhl-es",
			"name": "DHL Spain Domestic",
			"other_name": "DHL España",
			"required_fields": []
		},
		{
			"slug": "dhl-germany",
			"name": "Deutsche Post DHL",
			"other_name": "DHL Germany",
			"required_fields": []
		},
		{
			"slug": "dhl-global-mail",
			"name": "DHL eCommerce",
			"other_name": "DHL Global Mail",
			"required_fields": []
		},
		{
			"slug": "dhl-global-mail-asia",
			"name": "DHL Global Mail Asia",
			"other_name": "DGM Asia",
			"required_fields": []
		},
		{
			"slug": "dhl-nl",
			"name": "DHL Netherlands",
			"other_name": "DHL Nederlands",
			"required_fields": []
		},
		{
			"slug": "dhl-pieceid",
			"name": "DHL Express (Piece ID)",
			"other_name": "DHL International",
			"required_fields": []
		},
		{
			"slug": "dhl-poland",
			"name": "DHL Poland Domestic",
			"other_name": "DHL Polska",
			"required_fields": []
		},
		{
			"slug": "dhlparcel-nl",
			"name": "DHL Parcel NL",
			"other_name": "Selektvracht, dhlparcel.nl",
			"required_fields": []
		},
		{
			"slug": "directlink",
			"name": "Direct Link",
			"other_name": "Direct Link",
			"required_fields": []
		},
		{
			"slug": "dmm-network",
			"name": "DMM Network",
			"other_name": "dmmnetwork.it",
			"required_fields": []
		},
		{
			"slug": "dotzot",
			"name": "Dotzot",
			"other_name": "Dotzot",
			"required_fields": []
		},
		{
			"slug": "dpd",
			"name": "DPD",
			"other_name": "Dynamic Parcel Distribution",
			"required_fields": []
		},
		{
			"slug": "dpd-de",
			"name": "DPD Germany",
			"other_name": "DPD Germany",
			"required_fields": []
		},
		{
			"slug": "dpd-ireland",
			"name": "DPD Ireland",
			"other_name": "DPD ie",
			"required_fields": []
		},
		{
			"slug": "dpd-poland",
			"name": "DPD Poland",
			"other_name": "Dynamic Parcel Distribution Poland",
			"required_fields": []
		},
		{
			"slug": "dpd-uk",
			"name": "DPD UK",
			"other_name": "Dynamic Parcel Distribution UK",
			"required_fields": []
		},
		{
			"slug": "dpe-za",
			"name": "DPE South Africa",
			"other_name": "DPE Worldwide Express",
			"required_fields": []
		},
		{
			"slug": "dsv",
			"name": "DSV",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dtdc",
			"name": "DTDC India",
			"other_name": "DTDC Courier & Cargo",
			"required_fields": []
		},
		{
			"slug": "dynamic-logistics",
			"name": "Dynamic Logistics",
			"other_name": "Dynamic Logistics Thailand",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "easy-mail",
			"name": "Easy Mail",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ec-firstclass",
			"name": "EC-Firstclass",
			"other_name": "ChuKou1, CK1",
			"required_fields": []
		},
		{
			"slug": "ecargo-asia",
			"name": "Ecargo",
			"other_name": "Ecargo Pte. Ltd",
			"required_fields": []
		},
		{
			"slug": "ecom-express",
			"name": "Ecom Express",
			"other_name": "EcomExpress",
			"required_fields": []
		},
		{
			"slug": "elta-courier",
			"name": "ELTA Hellenic Post",
			"other_name": "Greece Post, Ελληνικά Ταχυδρομεία, ELTA Courier, Ταχυμεταφορές ΕΛΤΑ",
			"required_fields": []
		},
		{
			"slug": "emirates-post",
			"name": "Emirates Post",
			"other_name": "مجموعة بريد الإمارات, UAE Post",
			"required_fields": []
		},
		{
			"slug": "empsexpress",
			"name": "EMPS Express",
			"other_name": "Shenzhen Express Mail & Parcel Service Freight Forwarding Co.,",
			"required_fields": []
		},
		{
			"slug": "envialia",
			"name": "Envialia",
			"other_name": "Envialia Spain",
			"required_fields": []
		},
		{
			"slug": "equick-cn",
			"name": "Equick China",
			"other_name": "北京网易速达",
			"required_fields": []
		},
		{
			"slug": "estafeta",
			"name": "Estafeta",
			"other_name": "Estafeta Mexicana",
			"required_fields": []
		},
		{
			"slug": "estes",
			"name": "Estes",
			"other_name": "Estes Express Lines",
			"required_fields": []
		},
		{
			"slug": "exapaq",
			"name": "Exapaq",
			"other_name": "DPD France",
			"required_fields": []
		},
		{
			"slug": "fastrak-th",
			"name": "Fastrak Services",
			"other_name": "Fastrak Advanced Delivery Systems",
			"required_fields": []
		},
		{
			"slug": "fastway-au",
			"name": "Fastway Australia",
			"other_name": "Fastway Couriers",
			"required_fields": []
		},
		{
			"slug": "fastway-ireland",
			"name": "Fastway Ireland",
			"other_name": "Fastway Couriers",
			"required_fields": []
		},
		{
			"slug": "fastway-nz",
			"name": "Fastway New Zealand",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fastway-za",
			"name": "Fastway South Africa",
			"other_name": "Fastway Couriers",
			"required_fields": []
		},
		{
			"slug": "fedex",
			"name": "FedEx",
			"other_name": "Federal Express",
			"required_fields": []
		},
		{
			"slug": "fedex-uk",
			"name": "FedEx UK",
			"other_name": "FedEx United Kingdom",
			"required_fields": []
		},
		{
			"slug": "fercam",
			"name": "FERCAM Logistics & Transport",
			"other_name": "FERCAM SpA",
			"required_fields": []
		},
		{
			"slug": "first-flight",
			"name": "First Flight Couriers",
			"other_name": "FirstFlight India",
			"required_fields": []
		},
		{
			"slug": "first-logistics",
			"name": "First Logistics",
			"other_name": "PT Synergy First Logistics",
			"required_fields": []
		},
		{
			"slug": "flytexpress",
			"name": "Flyt Express",
			"other_name": "飞特物流",
			"required_fields": []
		},
		{
			"slug": "gati-kwe",
			"name": "Gati-KWE",
			"other_name": "Gati-Kintetsu Express",
			"required_fields": []
		},
		{
			"slug": "gdex",
			"name": "GDEX",
			"other_name": "GD Express",
			"required_fields": []
		},
		{
			"slug": "geodis-calberson-fr",
			"name": "Geodis Calberson France",
			"other_name": "Geodiscalberson",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "ghn",
			"name": "Giao hàng nhanh",
			"other_name": "Giaohangnhanh.vn, GHN",
			"required_fields": []
		},
		{
			"slug": "globegistics",
			"name": "Globegistics Inc.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gls",
			"name": "GLS",
			"other_name": "General Logistics Systems",
			"required_fields": []
		},
		{
			"slug": "gls-italy",
			"name": "GLS Italy",
			"other_name": "GLS Corriere Espresso",
			"required_fields": []
		},
		{
			"slug": "gls-netherlands",
			"name": "GLS Netherlands",
			"other_name": "GLS NL",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "gojavas",
			"name": "GoJaVAS",
			"other_name": "JaVAS",
			"required_fields": []
		},
		{
			"slug": "greyhound",
			"name": "Greyhound",
			"other_name": "Greyhound Package Express",
			"required_fields": []
		},
		{
			"slug": "hermes",
			"name": "Hermesworld",
			"other_name": "Hermes-europe UK",
			"required_fields": []
		},
		{
			"slug": "hermes-de",
			"name": "Hermes Germany",
			"other_name": "myhermes.de, Hermes Logistik Gruppe Deutschland",
			"required_fields": []
		},
		{
			"slug": "homedirect-logistics",
			"name": "Homedirect Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hong-kong-post",
			"name": "Hong Kong Post",
			"other_name": "香港郵政",
			"required_fields": []
		},
		{
			"slug": "hrvatska-posta",
			"name": "Hrvatska Pošta",
			"other_name": "Croatia Post",
			"required_fields": []
		},
		{
			"slug": "i-parcel",
			"name": "i-parcel",
			"other_name": "iparcel",
			"required_fields": []
		},
		{
			"slug": "india-post",
			"name": "India Post Domestic",
			"other_name": "भारतीय डाक",
			"required_fields": []
		},
		{
			"slug": "india-post-int",
			"name": "India Post International",
			"other_name": "भारतीय डाक, Speed Post & eMO, EMS, IPS Web",
			"required_fields": []
		},
		{
			"slug": "interlink-express",
			"name": "Interlink Express",
			"other_name": "Interlink UK",
			"required_fields": []
		},
		{
			"slug": "international-seur",
			"name": "International Seur",
			"other_name": "SEUR Internacional",
			"required_fields": []
		},
		{
			"slug": "israel-post",
			"name": "Israel Post",
			"other_name": "חברת דואר ישראל",
			"required_fields": []
		},
		{
			"slug": "israel-post-domestic",
			"name": "Israel Post Domestic",
			"other_name": "חברת דואר ישראל מקומית",
			"required_fields": []
		},
		{
			"slug": "italy-sda",
			"name": "Italy SDA",
			"other_name": "SDA Express Courier",
			"required_fields": []
		},
		{
			"slug": "jam-express",
			"name": "Jam Express",
			"other_name": "JAM Global Express",
			"required_fields": []
		},
		{
			"slug": "japan-post",
			"name": "Japan Post",
			"other_name": "日本郵便",
			"required_fields": []
		},
		{
			"slug": "jayonexpress",
			"name": "Jayon Express (JEX)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jcex",
			"name": "JCEX",
			"other_name": "JiaCheng, 杭州佳成",
			"required_fields": []
		},
		{
			"slug": "jne",
			"name": "JNE",
			"other_name": "Express Across Nation, Tiki Jalur Nugraha Ekakurir",
			"required_fields": []
		},
		{
			"slug": "kangaroo-my",
			"name": "Kangaroo Worldwide Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kerry-logistics",
			"name": "Kerry Express Thailand",
			"other_name": "嘉里物流, Kerry Logistics",
			"required_fields": []
		},
		{
			"slug": "kn",
			"name": "Kuehne + Nagel",
			"other_name": "KN",
			"required_fields": []
		},
		{
			"slug": "korea-post",
			"name": "Korea Post",
			"other_name": "우정사업본부",
			"required_fields": []
		},
		{
			"slug": "la-poste-colissimo",
			"name": "La Poste",
			"other_name": "Coliposte",
			"required_fields": []
		},
		{
			"slug": "lasership",
			"name": "LaserShip",
			"other_name": "LaserShip",
			"required_fields": []
		},
		{
			"slug": "lbcexpress",
			"name": "LBC Express",
			"other_name": "LBC Express",
			"required_fields": []
		},
		{
			"slug": "lietuvos-pastas",
			"name": "Lietuvos paštas",
			"other_name": "Lithuania Post, LP Express",
			"required_fields": []
		},
		{
			"slug": "lwe-hk",
			"name": "Logistic Worldwide Express",
			"other_name": "LWE",
			"required_fields": []
		},
		{
			"slug": "magyar-posta",
			"name": "Magyar Posta",
			"other_name": "Hungarian Post",
			"required_fields": []
		},
		{
			"slug": "malaysia-post",
			"name": "Malaysia Post EMS / Poslaju",
			"other_name": "Pos Ekspres, Pos Malaysia Express",
			"required_fields": []
		},
		{
			"slug": "malaysia-post-posdaftar",
			"name": "Malaysia Post - Registered",
			"other_name": "PosDaftar",
			"required_fields": []
		},
		{
			"slug": "mexico-redpack",
			"name": "Mexico Redpack",
			"other_name": "TNT Mexico",
			"required_fields": []
		},
		{
			"slug": "mexico-senda-express",
			"name": "Mexico Senda Express",
			"other_name": "Mexico Senda Express",
			"required_fields": []
		},
		{
			"slug": "mrw-spain",
			"name": "MRW",
			"other_name": "MRW Spain",
			"required_fields": []
		},
		{
			"slug": "myhermes-uk",
			"name": "myHermes UK",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mypostonline",
			"name": "Mypostonline",
			"other_name": "MYBOXPOST",
			"required_fields": []
		},
		{
			"slug": "nacex-spain",
			"name": "NACEX Spain",
			"other_name": "NACEX Logista",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "nanjingwoyuan",
			"name": "Nanjing Woyuan",
			"other_name": "u6c83u6e90",
			"required_fields": []
		},
		{
			"slug": "nationwide-my",
			"name": "Nationwide Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "new-zealand-post",
			"name": "New Zealand Post",
			"other_name": "NZ Post",
			"required_fields": []
		},
		{
			"slug": "newgistics",
			"name": "Newgistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "nipost",
			"name": "NiPost",
			"other_name": "Nigerian Postal Service",
			"required_fields": []
		},
		{
			"slug": "nova-poshta",
			"name": "Nova Poshta",
			"other_name": "Новая Почта",
			"required_fields": []
		},
		{
			"slug": "oca-ar",
			"name": "OCA Argentina",
			"other_name": "OCA e-Pak",
			"required_fields": []
		},
		{
			"slug": "ontrac",
			"name": "OnTrac",
			"other_name": "OnTrac Shipping",
			"required_fields": []
		},
		{
			"slug": "opek",
			"name": "FedEx Poland Domestic",
			"other_name": "OPEK",
			"required_fields": []
		},
		{
			"slug": "packlink",
			"name": "Packlink",
			"other_name": "Packlink Spain",
			"required_fields": []
		},
		{
			"slug": "pandulogistics",
			"name": "Pandu Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "panther",
			"name": "Panther",
			"other_name": "Panther Group UK",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "parcel-force",
			"name": "Parcel Force",
			"other_name": "Parcelforce UK",
			"required_fields": []
		},
		{
			"slug": "poczta-polska",
			"name": "Poczta Polska",
			"other_name": "Poland Post",
			"required_fields": []
		},
		{
			"slug": "portugal-ctt",
			"name": "Portugal CTT",
			"other_name": "Correios de Portugal",
			"required_fields": []
		},
		{
			"slug": "portugal-seur",
			"name": "Portugal Seur",
			"other_name": "SEUR",
			"required_fields": []
		},
		{
			"slug": "pos-indonesia",
			"name": "Pos Indonesia Domestic",
			"other_name": "Indonesian Post Domestic",
			"required_fields": []
		},
		{
			"slug": "pos-indonesia-int",
			"name": "Pos Indonesia Int'l",
			"other_name": "Indonesian Post International EMS",
			"required_fields": []
		},
		{
			"slug": "post56",
			"name": "Post56",
			"other_name": "捷邮快递",
			"required_fields": []
		},
		{
			"slug": "posta-romana",
			"name": "Poșta Română",
			"other_name": "Romania Post",
			"required_fields": []
		},
		{
			"slug": "poste-italiane",
			"name": "Poste Italiane",
			"other_name": "Italian Post",
			"required_fields": []
		},
		{
			"slug": "poste-italiane-paccocelere",
			"name": "Poste Italiane Paccocelere",
			"other_name": "Italian Post EMS / Express",
			"required_fields": []
		},
		{
			"slug": "posten-norge",
			"name": "Posten Norge / Bring",
			"other_name": "Norway Post, Norska Posten",
			"required_fields": []
		},
		{
			"slug": "posti",
			"name": "Itella Posti",
			"other_name": "Finland Post",
			"required_fields": []
		},
		{
			"slug": "postnl",
			"name": "PostNL Domestic",
			"other_name": "PostNL Pakketten, TNT Post Netherlands",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "postnl-3s",
			"name": "PostNL International 3S",
			"other_name": "TNT Post parcel service United Kingdom",
			"required_fields": [
				"tracking_destination_country",
				"tracking_postal_code"
			]
		},
		{
			"slug": "postnl-international",
			"name": "PostNL International",
			"other_name": "Netherlands Post, Spring Global Mail",
			"required_fields": []
		},
		{
			"slug": "postnord",
			"name": "PostNord Logistics",
			"other_name": "Posten Norden",
			"required_fields": []
		},
		{
			"slug": "ppbyb",
			"name": "PayPal Package",
			"other_name": "贝邮宝",
			"required_fields": []
		},
		{
			"slug": "professional-couriers",
			"name": "Professional Couriers",
			"other_name": "TPC India",
			"required_fields": []
		},
		{
			"slug": "ptt-posta",
			"name": "PTT Posta",
			"other_name": "Turkish Post",
			"required_fields": []
		},
		{
			"slug": "purolator",
			"name": "Purolator",
			"other_name": "Purolator Freight",
			"required_fields": []
		},
		{
			"slug": "qxpress",
			"name": "Qxpress",
			"other_name": "Qxpress Qoo10",
			"required_fields": []
		},
		{
			"slug": "raf",
			"name": "RAF Philippines",
			"other_name": "RAF Int'l. Forwarding",
			"required_fields": []
		},
		{
			"slug": "ramgroup-za",
			"name": "RAM",
			"other_name": "RAM Group",
			"required_fields": []
		},
		{
			"slug": "red-express",
			"name": "Red Express",
			"other_name": "Red Express",
			"required_fields": []
		},
		{
			"slug": "red-express-wb",
			"name": "Red Express Waybill",
			"other_name": "Red Express WayBill",
			"required_fields": []
		},
		{
			"slug": "redur-es",
			"name": "Redur Spain",
			"other_name": "Eurodis",
			"required_fields": []
		},
		{
			"slug": "rl-carriers",
			"name": "RL Carriers",
			"other_name": "R+L Carriers",
			"required_fields": []
		},
		{
			"slug": "royal-mail",
			"name": "Royal Mail",
			"other_name": "Royal Mail United Kingdom",
			"required_fields": []
		},
		{
			"slug": "rpx",
			"name": "RPX Indonesia",
			"other_name": "Repex Perdana International",
			"required_fields": []
		},
		{
			"slug": "rpxonline",
			"name": "RPX Online",
			"other_name": "Cathay Pacific",
			"required_fields": []
		},
		{
			"slug": "russian-post",
			"name": "Russian Post",
			"other_name": "Почта России, EMS Post RU",
			"required_fields": []
		},
		{
			"slug": "safexpress",
			"name": "Safexpress",
			"other_name": "Safexpress",
			"required_fields": []
		},
		{
			"slug": "sagawa",
			"name": "Sagawa",
			"other_name": "佐川急便",
			"required_fields": []
		},
		{
			"slug": "sapo",
			"name": "South African Post Office",
			"other_name": "South African Post Office",
			"required_fields": []
		},
		{
			"slug": "saudi-post",
			"name": "Saudi Post",
			"other_name": "البريد السعودي",
			"required_fields": []
		},
		{
			"slug": "sf-express",
			"name": "S.F. Express",
			"other_name": "順豊快遞",
			"required_fields": []
		},
		{
			"slug": "sfb2c",
			"name": "S.F International",
			"other_name": "順豐國際",
			"required_fields": []
		},
		{
			"slug": "sgt-it",
			"name": "SGT Corriere Espresso",
			"other_name": "SoGeTras Corriere Espresso",
			"required_fields": []
		},
		{
			"slug": "sic-teliway",
			"name": "Teliway SIC Express",
			"other_name": "Prevote",
			"required_fields": [
				"tracking_account_number",
				"tracking_key"
			]
		},
		{
			"slug": "singapore-post",
			"name": "Singapore Post",
			"other_name": "SingPost",
			"required_fields": []
		},
		{
			"slug": "singapore-speedpost",
			"name": "Singapore Speedpost",
			"other_name": "Singapore EMS",
			"required_fields": []
		},
		{
			"slug": "siodemka",
			"name": "Siodemka",
			"other_name": "Siodemka Kurier",
			"required_fields": []
		},
		{
			"slug": "skynet",
			"name": "SkyNet Malaysia",
			"other_name": "SkyNet MY",
			"required_fields": []
		},
		{
			"slug": "skynetworldwide",
			"name": "SkyNet Worldwide Express",
			"other_name": "Skynetwwe",
			"required_fields": []
		},
		{
			"slug": "skynetworldwide-uk",
			"name": "Skynet Worldwide Express UK",
			"other_name": "Skynet UK",
			"required_fields": []
		},
		{
			"slug": "spain-correos-es",
			"name": "Correos de España",
			"other_name": "Spain Post, ChronoExpress",
			"required_fields": []
		},
		{
			"slug": "spanish-seur",
			"name": "Spanish Seur",
			"other_name": "SEUR",
			"required_fields": []
		},
		{
			"slug": "specialisedfreight-za",
			"name": "Specialised Freight",
			"other_name": "SFS",
			"required_fields": []
		},
		{
			"slug": "speedcouriers-gr",
			"name": "Speed Couriers",
			"other_name": "Speed Couriers",
			"required_fields": []
		},
		{
			"slug": "speedexcourier",
			"name": "Speedex Courier",
			"other_name": "Speedex Courier",
			"required_fields": []
		},
		{
			"slug": "spreadel",
			"name": "Spreadel",
			"other_name": "Jabong delivery",
			"required_fields": []
		},
		{
			"slug": "srekorea",
			"name": "SRE Korea",
			"other_name": "SRE 배송서비스",
			"required_fields": []
		},
		{
			"slug": "star-track",
			"name": "StarTrack",
			"other_name": "Star Track",
			"required_fields": []
		},
		{
			"slug": "star-track-express",
			"name": "Star Track Express",
			"other_name": "AaE Australian air Express",
			"required_fields": []
		},
		{
			"slug": "sto",
			"name": "STO Express",
			"other_name": "申通快递, Shentong Express",
			"required_fields": []
		},
		{
			"slug": "sweden-posten",
			"name": "Sweden Posten",
			"other_name": "Sweden Post",
			"required_fields": []
		},
		{
			"slug": "swiss-post",
			"name": "Swiss Post",
			"other_name": "La Poste Suisse, Die Schweizerische Post, Die Post",
			"required_fields": []
		},
		{
			"slug": "szdpex",
			"name": "DPEX China",
			"other_name": "DPEX（深圳）国际物流, Toll China",
			"required_fields": []
		},
		{
			"slug": "taiwan-post",
			"name": "Taiwan Post",
			"other_name": "Chunghwa Post, 台灣中華郵政",
			"required_fields": []
		},
		{
			"slug": "taqbin-hk",
			"name": "TAQBIN Hong Kong",
			"other_name": "Yamat, 雅瑪多運輸- 宅急便",
			"required_fields": []
		},
		{
			"slug": "taqbin-jp",
			"name": "Yamato Japan",
			"other_name": "ヤマト運輸, TAQBIN",
			"required_fields": []
		},
		{
			"slug": "taqbin-my",
			"name": "TAQBIN Malaysia",
			"other_name": "TAQBIN Malaysia",
			"required_fields": []
		},
		{
			"slug": "taqbin-sg",
			"name": "TAQBIN Singapore",
			"other_name": "Yamato Singapore",
			"required_fields": []
		},
		{
			"slug": "taxydromiki",
			"name": "Geniki Taxydromiki",
			"other_name": "ΓΕΝΙΚΗ ΤΑΧΥΔΡΟΜΙΚΗ",
			"required_fields": []
		},
		{
			"slug": "tgx",
			"name": "TGX",
			"other_name": "Top Gun Express, 精英速運",
			"required_fields": []
		},
		{
			"slug": "thailand-post",
			"name": "Thailand Thai Post",
			"other_name": "ไปรษณีย์ไทย",
			"required_fields": []
		},
		{
			"slug": "tiki",
			"name": "Tiki",
			"other_name": "Citra Van Titipan Kilat",
			"required_fields": []
		},
		{
			"slug": "tnt",
			"name": "TNT",
			"other_name": "TNT Express",
			"required_fields": []
		},
		{
			"slug": "tnt-au",
			"name": "TNT Australia",
			"other_name": "TNT AU",
			"required_fields": []
		},
		{
			"slug": "tnt-click",
			"name": "TNT-Click Italy",
			"other_name": "TNT Italy",
			"required_fields": []
		},
		{
			"slug": "tnt-fr",
			"name": "TNT France",
			"other_name": "TNT Express FR",
			"required_fields": []
		},
		{
			"slug": "tnt-it",
			"name": "TNT Italy",
			"other_name": "TNT Express IT",
			"required_fields": []
		},
		{
			"slug": "tnt-uk",
			"name": "TNT UK",
			"other_name": "TNT United Kingdom",
			"required_fields": []
		},
		{
			"slug": "tntpost-it",
			"name": "Nexive (TNT Post Italy)",
			"other_name": "Postnl TNT",
			"required_fields": []
		},
		{
			"slug": "toll-global-express",
			"name": "Toll Global Express",
			"other_name": "DPEX",
			"required_fields": []
		},
		{
			"slug": "toll-ipec",
			"name": "Toll IPEC",
			"other_name": "Toll Express",
			"required_fields": []
		},
		{
			"slug": "toll-priority",
			"name": "Toll Priority",
			"other_name": "Toll Group, Toll Priority",
			"required_fields": []
		},
		{
			"slug": "trakpak",
			"name": "TrakPak",
			"other_name": "bpost international P2P Mailing Trak Pak",
			"required_fields": []
		},
		{
			"slug": "transmission-nl",
			"name": "TransMission",
			"other_name": "mijnzending",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "tuffnells",
			"name": "Tuffnells Parcels Express",
			"other_name": "",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "ubi-logistics",
			"name": "UBI Logistics Australia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "uk-mail",
			"name": "UK Mail",
			"other_name": "Business Post Group",
			"required_fields": []
		},
		{
			"slug": "ukrposhta",
			"name": "UkrPoshta",
			"other_name": "Укрпошта",
			"required_fields": []
		},
		{
			"slug": "ups",
			"name": "UPS",
			"other_name": "United Parcel Service",
			"required_fields": []
		},
		{
			"slug": "ups-freight",
			"name": "UPS Freight",
			"other_name": "UPS LTL and Truckload",
			"required_fields": []
		},
		{
			"slug": "ups-mi",
			"name": "UPS Mail Innovations",
			"other_name": "UPS MI",
			"required_fields": []
		},
		{
			"slug": "usps",
			"name": "USPS",
			"other_name": "United States Postal Service",
			"required_fields": []
		},
		{
			"slug": "viettelpost",
			"name": "ViettelPost",
			"other_name": "Bưu chính Viettel",
			"required_fields": []
		},
		{
			"slug": "vnpost",
			"name": "Vietnam Post",
			"other_name": "VNPost",
			"required_fields": []
		},
		{
			"slug": "vnpost-ems",
			"name": "Vietnam Post EMS",
			"other_name": "VNPost EMS",
			"required_fields": []
		},
		{
			"slug": "wahana",
			"name": "Wahana",
			"other_name": "Wahana Indonesia",
			"required_fields": []
		},
		{
			"slug": "wedo",
			"name": "WeDo Logistics",
			"other_name": "運德物流",
			"required_fields": []
		},
		{
			"slug": "wishpost",
			"name": "WishPost",
			"other_name": "Wish",
			"required_fields": []
		},
		{
			"slug": "xdp-uk",
			"name": "XDP Express",
			"other_name": "XDP UK",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "xend",
			"name": "Xend Express",
			"other_name": "Xend Business Solutions",
			"required_fields": []
		},
		{
			"slug": "xpressbees",
			"name": "XpressBees",
			"other_name": "XpressBees logistics",
			"required_fields": []
		},
		{
			"slug": "yanwen",
			"name": "Yanwen",
			"other_name": "燕文物流",
			"required_fields": []
		},
		{
			"slug": "yodel",
			"name": "Yodel Domestic",
			"other_name": "Home Delivery Network Limited (HDNL)",
			"required_fields": []
		},
		{
			"slug": "yodel-international",
			"name": "Yodel International",
			"other_name": "Home Delivery Network, HDNL",
			"required_fields": []
		},
		{
			"slug": "yrc",
			"name": "YRC",
			"other_name": "YRC Freight",
			"required_fields": []
		},
		{
			"slug": "yundaex",
			"name": "Yunda Express",
			"other_name": "韵达快递",
			"required_fields": []
		},
		{
			"slug": "yunexpress",
			"name": "Yun Express",
			"other_name": "u4e91u9014u7269u6d41",
			"required_fields": []
		},
		{
			"slug": "zjs-express",
			"name": "ZJS International",
			"other_name": "宅急送快運",
			"required_fields": []
		}
	];
	return data;
}

