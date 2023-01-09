function get_aftership_couriers() {
	var data = [
		{
			"slug": "17postservice",
			"name": "17 Post Service",
			"other_name": "17PostService",
			"required_fields": []
		},
		{
			"slug": "2ebox",
			"name": "2ebox",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "2go",
			"name": "2GO",
			"other_name": "Negros Navigation",
			"required_fields": []
		},
		{
			"slug": "360lion",
			"name": "360 Lion Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "3jmslogistics",
			"name": "3JMS Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "4-72",
			"name": "4-72 Entregando",
			"other_name": "Colombia Postal Service",
			"required_fields": []
		},
		{
			"slug": "4px",
			"name": "4PX",
			"other_name": "递四方",
			"required_fields": []
		},
		{
			"slug": "6ls",
			"name": "绿色国际速递",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "800bestex",
			"name": "Best Express",
			"other_name": "百世汇通",
			"required_fields": []
		},
		{
			"slug": "99minutos",
			"name": "99minutos",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "a1post",
			"name": "A1Post",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "a2b-ba",
			"name": "A2B Express Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "aaa-cooper",
			"name": "AAA Cooper",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "abcustom",
			"name": "AB Custom Group",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "abcustom-sftp",
			"name": "AB Custom Group",
			"other_name": null,
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
			"slug": "acilogistix",
			"name": "ACI Logistix",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "acommerce",
			"name": "aCommerce",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "acscourier",
			"name": "ACS Courier",
			"other_name": "Αναζήτηση Καταστημάτων",
			"required_fields": []
		},
		{
			"slug": "acsworldwide",
			"name": "ACS Worldwide Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "activos24-api",
			"name": "Activos24",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "aderonline",
			"name": "Ader",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "adicional",
			"name": "Adicional Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "adsone",
			"name": "ADSOne",
			"other_name": "ADSOne Group",
			"required_fields": []
		},
		{
			"slug": "aduiepyle",
			"name": "A Duie Pyle",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "aeroflash",
			"name": "Mexico AeroFlash",
			"other_name": "AeroFlash",
			"required_fields": []
		},
		{
			"slug": "aeronet",
			"name": "Aeronet",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "aex",
			"name": "AEX Group",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "afllog-ftp",
			"name": "AFL LOGISTICS",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "agediss-sftp",
			"name": "Agediss",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "agility",
			"name": "Agility",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "air-canada",
			"name": "Rivo",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "air-canada-global",
			"name": "Rivo",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "air21",
			"name": "AIR21",
			"other_name": "AIR 21 PH",
			"required_fields": []
		},
		{
			"slug": "airmee-webhook",
			"name": "Airmee",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "airpak-express",
			"name": "Airpak Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "airspeed",
			"name": "Airspeed International Corporation",
			"other_name": "Airspeed Philippines",
			"required_fields": []
		},
		{
			"slug": "airterra",
			"name": "Airterra",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "aitworldwide-api",
			"name": "AIT",
			"other_name": "AIT Worldwide Logistics",
			"required_fields": []
		},
		{
			"slug": "alfatrex",
			"name": "AlfaTrex",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "allied-express-ftp",
			"name": "Allied Express (FTP)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "alliedexpress",
			"name": "Allied Express",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "alljoy",
			"name": "ALLJOY SUPPLY CHAIN CO., LTD",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "alphafast",
			"name": "alphaFAST",
			"other_name": "Alpha",
			"required_fields": []
		},
		{
			"slug": "always-express",
			"name": "Always Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "amazon",
			"name": "Amazon Shipping + Amazon MCF",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "amazon-email-push",
			"name": "Amazon",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "amazon-fba-swiship",
			"name": "Swiship UK",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "amazon-fba-swiship-de",
			"name": "Swiship DE",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "amazon-fba-swiship-in",
			"name": "Swiship IN",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "amazon-order",
			"name": "Amazon order",
			"other_name": null,
			"required_fields": [
				"tracking_key"
			]
		},
		{
			"slug": "amazon-uk-api",
			"name": "Amazon Shipping",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "amsegroup",
			"name": "AMS Group",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "amstan",
			"name": "Amstan Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "an-post",
			"name": "An Post",
			"other_name": "Ireland Post",
			"required_fields": []
		},
		{
			"slug": "andreani",
			"name": "Grupo logistico Andreani",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "andreani-api",
			"name": "Andreani",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "anicamboxexpress",
			"name": "ANICAM BOX EXPRESS",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "anjun",
			"name": "Anjun",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "anserx",
			"name": "ANSERX",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "anteraja",
			"name": "Anteraja",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "ao-courier",
			"name": "AO Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ao-deutschland",
			"name": "AO Deutschland Ltd.",
			"other_name": null,
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
			"other_name": "Net Despatch",
			"required_fields": []
		},
		{
			"slug": "apc-overnight-connum",
			"name": "APC Overnight Consignment Number",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "apg",
			"name": "APG eCommerce Solutions Ltd.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "aprisaexpress",
			"name": "Aprisa Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "aquiline",
			"name": "Aquiline",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "aramex",
			"name": "Aramex",
			"other_name": "ارامكس",
			"required_fields": []
		},
		{
			"slug": "aramex-api",
			"name": "Aramex",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "araskargo",
			"name": "Aras Cargo",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "arco-spedizioni",
			"name": "Arco Spedizioni SP",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "argents-webhook",
			"name": "Argents Express Group",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "ark-logistics",
			"name": "ARK Logistics",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
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
			"slug": "ase",
			"name": "ASE KARGO",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "asendia-de",
			"name": "Asendia Germany",
			"other_name": "Asendia De",
			"required_fields": []
		},
		{
			"slug": "asendia-hk",
			"name": "Asendia APAC",
			"other_name": "",
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
			"slug": "asigna",
			"name": "ASIGNA",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "asm",
			"name": "ASM(GLS Spain)",
			"other_name": "Asm-Red",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "atshealthcare",
			"name": "ATS Healthcare",
			"other_name": "ATS Healthcare",
			"required_fields": []
		},
		{
			"slug": "atshealthcare-reference",
			"name": "ATS Healthcare",
			"other_name": "ATS Healthcare",
			"required_fields": []
		},
		{
			"slug": "auexpress",
			"name": "Au Express",
			"other_name": null,
			"required_fields": []
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
			"slug": "australia-post-api",
			"name": "Australia Post API",
			"other_name": "",
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
			"slug": "averitt",
			"name": "Averitt Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "axlehire",
			"name": "AxleHire",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "axlehire-ftp",
			"name": "Axlehire",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "b2ceurope",
			"name": "B2C Europe",
			"other_name": "trackyourparcel.eu",
			"required_fields": [
				"tracking_postal_code",
				"tracking_destination_country"
			]
		},
		{
			"slug": "barqexp",
			"name": "Barq",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bdmnet",
			"name": "BDMnet",
			"other_name": "BDMnet",
			"required_fields": []
		},
		{
			"slug": "be",
			"name": "北俄国际",
			"other_name": null,
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
			"slug": "besttransport-sftp",
			"name": "Best Transport",
			"other_name": "Best transport AB",
			"required_fields": []
		},
		{
			"slug": "bestwayparcel",
			"name": "Best Way Parcel",
			"other_name": "",
			"required_fields": [
				"tracking_key"
			]
		},
		{
			"slug": "bettertrucks",
			"name": "Better Trucks",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "bgpost",
			"name": "Bulgarian Posts",
			"other_name": "Български пощи",
			"required_fields": []
		},
		{
			"slug": "bh-posta",
			"name": "JP BH Pošta",
			"other_name": "Bosnia and Herzegovina Post",
			"required_fields": []
		},
		{
			"slug": "bh-worldwide",
			"name": "B&H Worldwide",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "biocair-ftp",
			"name": "BioCair",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "birdsystem",
			"name": "BirdSystem",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bjshomedelivery",
			"name": "BJS Distribution, Storage & Couriers",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bjshomedelivery-ftp",
			"name": "BJS Distribution, Storage & Couriers - FTP",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "blinklastmile",
			"name": "Blink",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "bluecare",
			"name": "Bluecare Express Ltd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bluedart",
			"name": "Bluedart",
			"other_name": "Blue Dart Express",
			"required_fields": []
		},
		{
			"slug": "bluestar",
			"name": "Blue Star",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "bluex",
			"name": "Blue Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bneed",
			"name": "Bneed",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bollore-logistics",
			"name": "Bollore Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "bombinoexp",
			"name": "Bombino Express Pvt Ltd",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "bomi",
			"name": "Bomi Group",
			"other_name": null,
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "bond",
			"name": "Bond",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "bondscouriers",
			"name": "Bonds Couriers",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "borderexpress",
			"name": "Border Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "box-berry",
			"name": "Boxberry",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "boxc",
			"name": "BoxC",
			"other_name": "BOXC快遞",
			"required_fields": []
		},
		{
			"slug": "bpost",
			"name": "Bpost",
			"other_name": "Belgian Post, Belgium Post",
			"required_fields": []
		},
		{
			"slug": "bpost-api",
			"name": "Bpost API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "bpost-international",
			"name": "Bpost international",
			"other_name": "Landmark Global",
			"required_fields": []
		},
		{
			"slug": "brazil-correios",
			"name": "Brazil Correios",
			"other_name": "Brazilian Post",
			"required_fields": []
		},
		{
			"slug": "bring",
			"name": "Bring",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "brouwer-transport",
			"name": "Brouwer Transport en Logistiek B.V.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "brt-it",
			"name": "BRT Bartolini",
			"other_name": "BRT Corriere Espresso, DPD Italy",
			"required_fields": []
		},
		{
			"slug": "brt-it-api",
			"name": "BRT Bartolini API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "brt-it-parcelid",
			"name": "BRT Bartolini(Parcel ID)",
			"other_name": "BRT Corriere Espresso, DPD Italy",
			"required_fields": []
		},
		{
			"slug": "brt-it-sender-ref",
			"name": "BRT Bartolini(Sender Reference)",
			"other_name": "",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "budbee-webhook",
			"name": "Budbee",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "buffalo",
			"name": "BUFFALO",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "burd",
			"name": "Burd Delivery",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "buylogic",
			"name": "Buylogic",
			"other_name": "捷买送",
			"required_fields": []
		},
		{
			"slug": "cae-delivers",
			"name": "CAE Delivers",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cainiao",
			"name": "Cainiao",
			"other_name": "CAINIAO",
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
			"slug": "capital",
			"name": "Capital Transport",
			"other_name": "",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "caribou",
			"name": "Caribou",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "carriers",
			"name": "Carriers",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "carry-flap",
			"name": "Carry-Flap Co.,Ltd.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cbl-logistica",
			"name": "CBL Logistica",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cbl-logistica-api",
			"name": "CBL Logistica (API)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cdek",
			"name": "CDEK",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "cdek-tr",
			"name": "CDEK TR",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cdldelivers",
			"name": "CDL Last Mile",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "celeritas",
			"name": "Celeritas Transporte, S.L",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cello-square",
			"name": "Cello Square",
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
			"slug": "ceskaposta-api",
			"name": "Czech Post",
			"other_name": "Česká pošta",
			"required_fields": []
		},
		{
			"slug": "ceva",
			"name": "CEVA LOGISTICS",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ceva-tracking",
			"name": "CEVA Package",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cfl-logistics",
			"name": "CFL Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cgs-express",
			"name": "CGS Express",
			"other_name": "超光速",
			"required_fields": []
		},
		{
			"slug": "champion-logistics",
			"name": "Champion Logistics",
			"other_name": "Champlog",
			"required_fields": []
		},
		{
			"slug": "chazki",
			"name": "Chazki",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "chilexpress",
			"name": "Chile Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "china-ems",
			"name": "China EMS (ePacket)",
			"other_name": "中国邮政速递物流, ePacket, e-Packet, e Packet",
			"required_fields": []
		},
		{
			"slug": "china-post",
			"name": "China Post",
			"other_name": "中国邮政",
			"required_fields": []
		},
		{
			"slug": "chitchats",
			"name": "Chit Chats",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "choirexpress",
			"name": "Choir Express Indonesia",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "chrobinson",
			"name": "C.H. Robinson Worldwide, Inc.",
			"other_name": "",
			"required_fields": [
				"tracking_key"
			]
		},
		{
			"slug": "chronopost-france",
			"name": "Chronopost France",
			"other_name": "La Poste EMS",
			"required_fields": []
		},
		{
			"slug": "chronopost-portugal",
			"name": "Chronopost Portugal(DPD)",
			"other_name": "Chronopost pt",
			"required_fields": []
		},
		{
			"slug": "city56-webhook",
			"name": "City Express",
			"other_name": null,
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
			"slug": "cj-hk-international",
			"name": "CJ Logistics International(Hong Kong)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "cj-korea-thai",
			"name": "CJ Korea Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cj-malaysia-international",
			"name": "CJ Century (International)",
			"other_name": "CJ Logistics",
			"required_fields": []
		},
		{
			"slug": "cj-philippines",
			"name": "CJ Transnational Philippines",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cjlogistics",
			"name": "CJ Logistics International",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cjpacket",
			"name": "CJ Packet",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cle-logistics",
			"name": "CL E-Logistics Solutions Limited",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "clevy-links",
			"name": "Clevy Links",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "clicklink-sftp",
			"name": "ClickLink",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "cloudwish-asia",
			"name": "Cloudwish Asia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cn-logistics",
			"name": "CN Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "cndexpress",
			"name": "CND Express",
			"other_name": "辰诺达",
			"required_fields": []
		},
		{
			"slug": "cnexps",
			"name": "CNE Express",
			"other_name": "国际快递",
			"required_fields": []
		},
		{
			"slug": "cnwangtong",
			"name": "cnwangtong",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "colis-prive",
			"name": "Colis Privé",
			"other_name": "ColisPrivé",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "colissimo",
			"name": "Colissimo",
			"other_name": "Colissimo fr",
			"required_fields": []
		},
		{
			"slug": "collectco",
			"name": "CollectCo",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "collectplus",
			"name": "Collect+",
			"other_name": "Collect Plus UK",
			"required_fields": []
		},
		{
			"slug": "collivery",
			"name": "MDS Collivery Pty (Ltd)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "com1express",
			"name": "ComOne Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "comet-tech",
			"name": "CometTech",
			"other_name": "彗星科技",
			"required_fields": []
		},
		{
			"slug": "con-way",
			"name": "Con-way Freight",
			"other_name": "Conway",
			"required_fields": []
		},
		{
			"slug": "concise",
			"name": "Concise",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "concise-api",
			"name": "Concise",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "concise-webhook",
			"name": "Concise",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "continental",
			"name": "Continental",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "coordinadora",
			"name": "Coordinadora",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "coordinadora-api",
			"name": "Coordinadora",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "copa-courier",
			"name": "Copa Airlines Courier",
			"other_name": "Copa Courier",
			"required_fields": []
		},
		{
			"slug": "cope",
			"name": "Cope Sensitive Freight",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "corporatecouriers-webhook",
			"name": "Corporate Couriers",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "correo-uy",
			"name": "Correo Uruguayo",
			"other_name": null,
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
			"required_fields": []
		},
		{
			"slug": "correosexpress-api",
			"name": "Correos Express (API)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "costmeticsnow",
			"name": "Cosmetics Now",
			"other_name": "CosmeticsNow",
			"required_fields": []
		},
		{
			"slug": "courant-plus",
			"name": "Courant Plus",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "courant-plus-api",
			"name": "Courant Plus",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "courex",
			"name": "Urbanfox",
			"other_name": "",
			"required_fields": []
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
			"slug": "cpacket",
			"name": "cPacket",
			"other_name": "cpacket",
			"required_fields": []
		},
		{
			"slug": "cpex",
			"name": "Captain Express International",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "crlexpress",
			"name": "CRL Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "croshot",
			"name": "Croshot",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "crossflight",
			"name": "Crossflight Limited",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "cryopdp-ftp",
			"name": "CryoPDP",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "cse",
			"name": "CSE",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ctc-express",
			"name": "CTC Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cubyn",
			"name": "Cubyn",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "cuckooexpress",
			"name": "Cuckoo Express",
			"other_name": "布谷鸟",
			"required_fields": []
		},
		{
			"slug": "customco-api",
			"name": "The Custom Companies",
			"other_name": null,
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
			"slug": "daeshin",
			"name": "Daeshin",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "daiglobaltrack",
			"name": "DAI Post",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "daiichi",
			"name": "Daiichi Freight System Inc",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dajin",
			"name": "Shanghai Aqrum Chemical Logistics Co.Ltd",
			"other_name": "Dajin",
			"required_fields": []
		},
		{
			"slug": "danmark-post",
			"name": "PostNord Denmark",
			"other_name": "Danmark Post",
			"required_fields": []
		},
		{
			"slug": "danniao",
			"name": "Danniao",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "danske-fragt",
			"name": "Danske Fragtmænd",
			"other_name": "Fragt DK",
			"required_fields": []
		},
		{
			"slug": "dao365",
			"name": "DAO365",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dawnwing",
			"name": "Dawn Wing",
			"other_name": "DPD Laser Express Logistics",
			"required_fields": []
		},
		{
			"slug": "dayross",
			"name": "Day & Ross",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dayton-freight",
			"name": "Dayton Freight",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dbschenker-api",
			"name": "DB Schenker",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dbschenker-b2b",
			"name": "DB Schenker B2B",
			"other_name": null,
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "dbschenker-iceland",
			"name": "DB Schenker Iceland",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dbschenker-se",
			"name": "DB Schenker",
			"other_name": "Deutsche Bahn",
			"required_fields": []
		},
		{
			"slug": "dbschenker-sv",
			"name": "DB Schenker Sweden",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ddexpress",
			"name": "DD Express Courier",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dealer-send",
			"name": "DealerSend",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "delhivery",
			"name": "Delhivery",
			"other_name": "Gharpay",
			"required_fields": []
		},
		{
			"slug": "deliver-it",
			"name": "Deliver-iT",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "delivere",
			"name": "deliverE",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "deliverr-sftp",
			"name": "Deliverr",
			"other_name": "Deliverr",
			"required_fields": []
		},
		{
			"slug": "deliveryontime",
			"name": "DELIVERYONTIME LOGISTICS PVT LTD",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "deliveryourparcel-za",
			"name": "Deliver Your Parcel",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "delnext",
			"name": "Delnext",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "deltec-courier",
			"name": "Deltec Courier",
			"other_name": "Deltec Interntional Courier",
			"required_fields": []
		},
		{
			"slug": "demandship",
			"name": "DemandShip",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "descartes",
			"name": "Innovel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "designertransport-webhook",
			"name": "Designer Transport",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "destiny",
			"name": "Destiny Transportation",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "detrack",
			"name": "Detrack",
			"other_name": "Detrack Singapore",
			"required_fields": []
		},
		{
			"slug": "deutsch-post",
			"name": "Deutsche Post Mail",
			"other_name": "dpdhl",
			"required_fields": []
		},
		{
			"slug": "dex-i",
			"name": "DEX-I",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dexpress-webhook",
			"name": "D Express",
			"other_name": "D Express",
			"required_fields": []
		},
		{
			"slug": "dhl",
			"name": "DHL Express",
			"other_name": "DHL International",
			"required_fields": []
		},
		{
			"slug": "dhl-active-tracing",
			"name": "DHL Active Tracing",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dhl-api",
			"name": "DHL",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhl-benelux",
			"name": "DHL Benelux",
			"other_name": "DHL TrackNet Benelux",
			"required_fields": []
		},
		{
			"slug": "dhl-ecommerce-gc",
			"name": "DHL eCommerce Greater China",
			"other_name": "DHL eCommerce Greater China",
			"required_fields": []
		},
		{
			"slug": "dhl-es",
			"name": "DHL Spain Domestic",
			"other_name": "DHL España",
			"required_fields": []
		},
		{
			"slug": "dhl-freight",
			"name": "DHL Freight",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhl-germany",
			"name": "Deutsche Post DHL",
			"other_name": "DHL Germany",
			"required_fields": []
		},
		{
			"slug": "dhl-global-forwarding-api",
			"name": "DHL Global Forwarding API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhl-global-mail",
			"name": "DHL eCommerce Solutions",
			"other_name": "DHL Global Mail",
			"required_fields": []
		},
		{
			"slug": "dhl-global-mail-api",
			"name": "DHL eCommerce Solutions",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhl-global-mail-asia",
			"name": "DHL eCommerce Asia",
			"other_name": "DGM Asia",
			"required_fields": []
		},
		{
			"slug": "dhl-global-mail-asia-api",
			"name": "DHL eCommerce Asia (API)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dhl-hk",
			"name": "DHL Hong Kong",
			"other_name": "DHL HK Domestic",
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
			"slug": "dhl-reference-api",
			"name": "DHL (Reference number)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhl-sftp",
			"name": "DHL Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhl-supply-chain-au",
			"name": "DHL Supply Chain Australia",
			"other_name": "DHL ConnectedView",
			"required_fields": []
		},
		{
			"slug": "dhl-supplychain-apac",
			"name": "DHL Supply Chain APAC",
			"other_name": null,
			"required_fields": [
				"tracking_destination_country"
			]
		},
		{
			"slug": "dhl-supplychain-id",
			"name": "DHL Supply Chain Indonesia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dhl-supplychain-in",
			"name": "DHL supply chain India",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dhlparcel-es",
			"name": "DHL Parcel Spain",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dhlparcel-nl",
			"name": "DHL Parcel NL",
			"other_name": "Selektvracht, dhlparcel.nl",
			"required_fields": []
		},
		{
			"slug": "dhlparcel-ru",
			"name": "DHL Parcel Russia",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dhlparcel-uk",
			"name": "DHL Parcel UK",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dialogo-logistica",
			"name": "Dialogo Logistica",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dialogo-logistica-api",
			"name": "Dialogo Logistica",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "diamondcouriers",
			"name": "Diamond Eurogistics Limited",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dicom",
			"name": "GLS Logistic Systems Canada Ltd./Dicom",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "didadi",
			"name": "DIDADI Logistics tech",
			"other_name": "嘀嗒嘀物流",
			"required_fields": []
		},
		{
			"slug": "dimerco",
			"name": "Dimerco Express Group",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "directcouriers",
			"name": "Direct Couriers",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "directfreight-au-ref",
			"name": "Direct Freight Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "directlog",
			"name": "Directlog",
			"other_name": "Direct Express",
			"required_fields": []
		},
		{
			"slug": "directparcels",
			"name": "Direct Parcels",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "direx",
			"name": "Direx",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dksh",
			"name": "DKSH",
			"other_name": null,
			"required_fields": [
				"tracking_destination_country"
			]
		},
		{
			"slug": "dmfgroup",
			"name": "DMF",
			"other_name": "DMF",
			"required_fields": []
		},
		{
			"slug": "dmm-network",
			"name": "DMM Network",
			"other_name": "dmmnetwork.it",
			"required_fields": []
		},
		{
			"slug": "dms-matrix",
			"name": "DMSMatrix",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dnj-express",
			"name": "DNJ Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dobropost",
			"name": "DobroPost",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "doora",
			"name": "Doora Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "doordash-webhook",
			"name": "DoorDash",
			"other_name": "",
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
			"slug": "dpd-at-sftp",
			"name": "DPD Austria",
			"other_name": "DPD AT",
			"required_fields": []
		},
		{
			"slug": "dpd-ch-sftp",
			"name": "DPD Switzerland",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dpd-de",
			"name": "DPD Germany",
			"other_name": "DPD Germany",
			"required_fields": []
		},
		{
			"slug": "dpd-hk",
			"name": "DPD HK",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dpd-hungary",
			"name": "DPD Hungary",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dpd-ireland",
			"name": "DPD Ireland",
			"other_name": "DPD ie",
			"required_fields": []
		},
		{
			"slug": "dpd-nl",
			"name": "DPD Netherlands",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dpd-poland",
			"name": "DPD Poland",
			"other_name": "Dynamic Parcel Distribution Poland",
			"required_fields": []
		},
		{
			"slug": "dpd-ro",
			"name": "DPD Romania",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dpd-ru",
			"name": "DPD Russia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dpd-sk-sftp",
			"name": "DPD Slovakia",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dpd-uk",
			"name": "DPD UK",
			"other_name": "Dynamic Parcel Distribution UK",
			"required_fields": []
		},
		{
			"slug": "dpd-uk-sftp",
			"name": "DPD UK",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dpe-express",
			"name": "DPE Express",
			"other_name": "Delivery Perfect Express Co.",
			"required_fields": []
		},
		{
			"slug": "dpe-za",
			"name": "DPE South Africa",
			"other_name": "DPE Worldwide Express",
			"required_fields": []
		},
		{
			"slug": "dpex",
			"name": "DPEX",
			"other_name": "TGX, Toll Global Express Asia",
			"required_fields": []
		},
		{
			"slug": "dsv",
			"name": "DSV",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dsv-reference",
			"name": "DSV Futurewave",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dtd",
			"name": "DTD Express",
			"other_name": "一站到岸",
			"required_fields": []
		},
		{
			"slug": "dtdc",
			"name": "DTDC India",
			"other_name": "DTDC Courier & Cargo",
			"required_fields": []
		},
		{
			"slug": "dtdc-au",
			"name": "DTDC Australia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dtdc-express",
			"name": "DTDC Express Global PTE LTD",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dx",
			"name": "DX",
			"other_name": "-",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "dx-b2b-connum",
			"name": "DX (B2B)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "dx-freight",
			"name": "DX Freight",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dx-sftp",
			"name": "DX",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "dylt",
			"name": "Daylight Transport, LLC",
			"other_name": "",
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
			"slug": "eastwestcourier-ftp",
			"name": "East West Courier Pte Ltd",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "easy-mail",
			"name": "Easy Mail",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ec-firstclass",
			"name": "Chukou1",
			"other_name": "出口易、Chukou1、CK1",
			"required_fields": []
		},
		{
			"slug": "ecargo-asia",
			"name": "Ecargo",
			"other_name": "Ecargo Pte. Ltd",
			"required_fields": []
		},
		{
			"slug": "ecexpress",
			"name": "ECexpress",
			"other_name": "ECexpress (Shanghai）Co.,Ltd",
			"required_fields": []
		},
		{
			"slug": "echo",
			"name": "Echo",
			"other_name": "Echo Global Logistics",
			"required_fields": []
		},
		{
			"slug": "ecms",
			"name": "ECMS International Logistics Co., Ltd.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ecom-express",
			"name": "Ecom Express",
			"other_name": "EcomExpress",
			"required_fields": []
		},
		{
			"slug": "ecoscooting",
			"name": "ECOSCOOTING",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ecoutier",
			"name": "eCoutier",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "edf-ftp",
			"name": "Eurodifarm",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "efs",
			"name": "EFS (E-commerce Fulfillment Service)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "efwnow-api",
			"name": "Estes Forwarding Worldwide",
			"other_name": "EFW",
			"required_fields": []
		},
		{
			"slug": "ekart",
			"name": "Ekart",
			"other_name": "Ekart Logistics",
			"required_fields": []
		},
		{
			"slug": "elian-post",
			"name": "Yilian (Elian) Supply Chain",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "elite-co",
			"name": "Elite Express",
			"other_name": null,
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
			"other_name": "快信快包",
			"required_fields": []
		},
		{
			"slug": "endeavour-delivery",
			"name": "Endeavour Delivery",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "ensenda",
			"name": "Ensenda",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "envialia",
			"name": "Envialia",
			"other_name": "Envialia Spain",
			"required_fields": []
		},
		{
			"slug": "envialia-reference",
			"name": "Envialia Reference",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "ep-box",
			"name": "EP-Box",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "eparcel-kr",
			"name": "eParcel Korea",
			"other_name": "Yong Seoung",
			"required_fields": []
		},
		{
			"slug": "epostglobal",
			"name": "ePost Global",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "equick-cn",
			"name": "Equick China",
			"other_name": "北京网易速达",
			"required_fields": []
		},
		{
			"slug": "esdex",
			"name": "Top Ideal Express",
			"other_name": "卓志速运",
			"required_fields": []
		},
		{
			"slug": "eshipping",
			"name": "Eshipping",
			"other_name": "Eshipping Global Supply Chain Management(Shenzhen)Co. Ltd",
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
			"slug": "etomars",
			"name": "Etomars",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "etotal",
			"name": "eTotal Solution Limited",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ets-express",
			"name": "RETS express",
			"other_name": "绥芬河俄通收国际货物运输代理有限责任公司",
			"required_fields": []
		},
		{
			"slug": "eu-fleet-solutions",
			"name": "EU Fleet Solutions",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "eurodis",
			"name": "Eurodis",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "europaket-api",
			"name": "Europacket+",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "ewe",
			"name": "EWE Global Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "exapaq",
			"name": "DPD France (formerly exapaq)",
			"other_name": "Exapaq",
			"required_fields": []
		},
		{
			"slug": "exelot-ftp",
			"name": "Exelot Ltd.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "expeditors",
			"name": "Expeditors",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "expeditors-api-ref",
			"name": "Expeditors API Reference",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "expresssale",
			"name": "Expresssale",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ezship",
			"name": "EZship",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fairsenden-api",
			"name": "fairsenden",
			"other_name": "fairsenden",
			"required_fields": []
		},
		{
			"slug": "fan",
			"name": "FAN COURIER EXPRESS",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "far-international",
			"name": "FAR international",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fargood",
			"name": "FarGood",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fastbox",
			"name": "Fastbox",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fastrak-th",
			"name": "Fastrak Services",
			"other_name": "Fastrak Advanced Delivery Systems",
			"required_fields": []
		},
		{
			"slug": "fasttrack",
			"name": "Fasttrack",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fastway-au",
			"name": "Aramex Australia (formerly Fastway AU)",
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
			"slug": "faxecargo",
			"name": "Faxe Cargo",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fdsexpress",
			"name": "FDSEXPRESS",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fedex",
			"name": "FedEx®",
			"other_name": "Federal Express",
			"required_fields": []
		},
		{
			"slug": "fedex-api",
			"name": "FedEx®",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fedex-crossborder",
			"name": "FedEx® Cross Border",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fedex-fims",
			"name": "FedEx International MailService®",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fedex-freight",
			"name": "FedEx® Freight",
			"other_name": "FedEx LTL",
			"required_fields": []
		},
		{
			"slug": "fedex-uk",
			"name": "FedEx® UK",
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
			"slug": "fetchr",
			"name": "Fetchr",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fetchr-webhook",
			"name": "Mena 360 (Fetchr)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fiege",
			"name": "Fiege Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fiege-nl",
			"name": "Fiege Netherlands",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "first-flight",
			"name": "First Flight Couriers",
			"other_name": "FirstFlight India",
			"required_fields": []
		},
		{
			"slug": "first-logistics-api",
			"name": "First Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "firstmile",
			"name": "FirstMile",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fitzmark-api",
			"name": "FitzMark",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "flashexpress",
			"name": "Flash Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "flipxp",
			"name": "FlipXpress",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "flytexpress",
			"name": "Flyt Express",
			"other_name": "飞特物流",
			"required_fields": []
		},
		{
			"slug": "fmx",
			"name": "FMX",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fnf-za",
			"name": "Fast & Furious",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fonsen",
			"name": "Fonsen Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "forrun",
			"name": "forrun Pvt Ltd (Arpatech Venture)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "forwardair",
			"name": "Forward Air",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fragilepak-sftp",
			"name": "FragilePAK",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "freightquote",
			"name": "Freightquote by C.H. Robinson",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "freterapido",
			"name": "Frete Rápido",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "frontdoorcorp",
			"name": "FRONTdoor Collective",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "fulfilla",
			"name": "Fulfilla",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "fulfillmen",
			"name": "Fulfillmen",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "furdeco",
			"name": "Furdeco",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "fxtran",
			"name": "Falcon Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gac-webhook",
			"name": "GAC",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gangbao",
			"name": "GANGBAO Supplychain",
			"other_name": "港宝供应链",
			"required_fields": []
		},
		{
			"slug": "gati-kwe",
			"name": "Gati-KWE",
			"other_name": "Gati-Kintetsu Express",
			"required_fields": []
		},
		{
			"slug": "gati-kwe-api",
			"name": "Gati-KWE",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gba",
			"name": "GBA Services Ltd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gbs-broker",
			"name": "GBS-Broker",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gdex",
			"name": "GDEX",
			"other_name": "GD Express",
			"required_fields": []
		},
		{
			"slug": "gdpharm",
			"name": "GDPharm Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "geis",
			"name": "Geis CZ",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gel-express",
			"name": "Gel Express Logistik",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "gemworldwide",
			"name": "GEM Worldwide",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "general-overnight",
			"name": "Go!Express and logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "geodis-api",
			"name": "GEODIS - Distribution & Express",
			"other_name": "云途物流",
			"required_fields": []
		},
		{
			"slug": "geodis-calberson-fr",
			"name": "GEODIS - Distribution & Express",
			"other_name": "Geodiscalberson",
			"required_fields": []
		},
		{
			"slug": "geodis-espace",
			"name": "Geodis E-space",
			"other_name": "Geodis Distribution & Express",
			"required_fields": [
				"tracking_key"
			]
		},
		{
			"slug": "geswl",
			"name": "GESWL Express",
			"other_name": "上海翼速国际物流",
			"required_fields": []
		},
		{
			"slug": "ghn",
			"name": "Giao hàng nhanh",
			"other_name": "Giaohangnhanh.vn, GHN",
			"required_fields": []
		},
		{
			"slug": "gio-ecourier",
			"name": "GIO Express Inc",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gio-ecourier-api",
			"name": "GIO Express Ecourier",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "global-express",
			"name": "Tai Wan Global Business",
			"other_name": "全球商务快递",
			"required_fields": []
		},
		{
			"slug": "globaltranz",
			"name": "GlobalTranz",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "globavend",
			"name": "Globavend",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "globegistics",
			"name": "Globegistics Inc.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "glovo",
			"name": "Glovo",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gls",
			"name": "GLS",
			"other_name": "General Logistics Systems",
			"required_fields": []
		},
		{
			"slug": "gls-croatia",
			"name": "GLS Croatia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gls-cz",
			"name": "GLS Czech Republic",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gls-italy",
			"name": "GLS Italy",
			"other_name": "GLS Corriere Espresso",
			"required_fields": []
		},
		{
			"slug": "gls-italy-ftp",
			"name": "GLS Italy",
			"other_name": "",
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
			"slug": "gls-slovakia",
			"name": "GLS General Logistics Systems Slovakia s.r.o.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gls-slovenia",
			"name": "GLS Slovenia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gls-spain",
			"name": "GLS Spain",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "gls-spain-api",
			"name": "GLS Spain",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "godependable",
			"name": "Dependable Supply Chain Services",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gofly",
			"name": "GoFly",
			"other_name": "GoFlyi",
			"required_fields": []
		},
		{
			"slug": "goglobalpost",
			"name": "Global Post",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gojavas",
			"name": "GoJavas",
			"other_name": "Javas",
			"required_fields": []
		},
		{
			"slug": "gojek-webhook",
			"name": "Gojek",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gols",
			"name": "GO Logistics & Storage",
			"other_name": "GOLS",
			"required_fields": []
		},
		{
			"slug": "gopeople",
			"name": "Go People",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gorush",
			"name": "Go Rush",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gpost",
			"name": "Georgian Post",
			"other_name": "Georgian Post",
			"required_fields": []
		},
		{
			"slug": "grab-webhook",
			"name": "Grab",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "greyhound",
			"name": "Greyhound",
			"other_name": "Greyhound Package Express",
			"required_fields": []
		},
		{
			"slug": "grupoampm",
			"name": "Grupo ampm",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gsi-express",
			"name": "GSI EXPRESS",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "gso",
			"name": "GSO(GLS-USA)",
			"other_name": "GSO Freight",
			"required_fields": []
		},
		{
			"slug": "gw-world",
			"name": "Gebrüder Weiss",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "gwlogis-api",
			"name": "G.I.G",
			"other_name": "G.I.G",
			"required_fields": []
		},
		{
			"slug": "hanjin",
			"name": "HanJin",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hct-logistics",
			"name": "HCT LOGISTICS CO.LTD.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hdb",
			"name": "Haidaibao",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hdb-box",
			"name": "Haidaibao (BOX)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hellenic-post",
			"name": "Hellenic (Greece) Post",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hellmann",
			"name": "Hellmann Worldwide Logistics, Inc",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "helthjem",
			"name": "Helthjem",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "helthjem-api",
			"name": "Helthjem",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "heppner",
			"name": "Heppner Internationale Spedition GmbH & Co.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "heppner-fr",
			"name": "Heppner France",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hermes",
			"name": "Hermesworld",
			"other_name": "Hermes-europe UK",
			"required_fields": []
		},
		{
			"slug": "hermes-2mann-handling",
			"name": "Hermes Einrichtungs Service GmbH & Co. KG",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hermes-de",
			"name": "Hermes Germany",
			"other_name": "myhermes.de, Hermes Logistik Gruppe Deutschland",
			"required_fields": []
		},
		{
			"slug": "hermes-de-ftp",
			"name": "Hermes Germany",
			"other_name": "myhermes.de, Hermes Logistik Gruppe Deutschland",
			"required_fields": []
		},
		{
			"slug": "hermes-it",
			"name": "HR Parcel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hermes-uk-sftp",
			"name": "Hermes UK",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "heroexpress",
			"name": "Hero Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hfd",
			"name": "HFD",
			"other_name": "Epost",
			"required_fields": []
		},
		{
			"slug": "hh-exp",
			"name": "Hua Han Logistics",
			"other_name": "u534eu7ff0u56fdu9645u7269u6d41",
			"required_fields": []
		},
		{
			"slug": "hipshipper",
			"name": "Hipshipper",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hkd",
			"name": "HKD International Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "holisol",
			"name": "Holisol",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "home-delivery-solutions",
			"name": "Home Delivery Solutions Ltd",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "homelogistics",
			"name": "Home Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "homerunner",
			"name": "HomeRunner",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hong-kong-post",
			"name": "Hong Kong Post",
			"other_name": "香港郵政",
			"required_fields": []
		},
		{
			"slug": "hotsin-cargo",
			"name": "SHENZHEN HOTSIN CARGO INT'L FORWARDING CO.,LTD",
			"other_name": "深圳市和兴国际货运代理有限公司",
			"required_fields": []
		},
		{
			"slug": "houndexpress",
			"name": "Hound Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hrparcel",
			"name": "HR Parcel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hrvatska-posta",
			"name": "Hrvatska Pošta",
			"other_name": "Croatia Post",
			"required_fields": []
		},
		{
			"slug": "hsdexpress",
			"name": "HSDEXPRESS",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hsm-global",
			"name": "HSM Global",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "huantong",
			"name": "HuanTong",
			"other_name": "环通跨境物流",
			"required_fields": []
		},
		{
			"slug": "hubbed",
			"name": "HUBBED",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "hunter-express",
			"name": "Hunter Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "hunter-express-sftp",
			"name": "Hunter Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "huodull",
			"name": "Huodull",
			"other_name": "货兜",
			"required_fields": []
		},
		{
			"slug": "hx-express",
			"name": "HX Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "i-dika",
			"name": "i-dika",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "i-parcel",
			"name": "i-parcel",
			"other_name": "iparcel",
			"required_fields": []
		},
		{
			"slug": "ibeone",
			"name": "Beone Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "icscourier",
			"name": "ICS COURIER",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "icumulus",
			"name": "iCumulus",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "idexpress",
			"name": "IDEX",
			"other_name": "上海宏杉国际物流",
			"required_fields": []
		},
		{
			"slug": "idexpress-id",
			"name": "iDexpress Indonesia",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "ilyanglogis",
			"name": "Ilyang logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "imile-api",
			"name": "iMile",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "iml",
			"name": "IML",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "imxmail",
			"name": "IMX Mail",
			"other_name": "IMX International Mail Consolidator",
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
			"slug": "indopaket",
			"name": "INDOPAKET",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "inexpost",
			"name": "Inexpost",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "inntralog-sftp",
			"name": "Inntralog GmbH",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "inpost-paczkomaty",
			"name": "InPost Paczkomaty",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "inpost-uk",
			"name": "InPost",
			"other_name": "InPost",
			"required_fields": []
		},
		{
			"slug": "instabox-webhook",
			"name": "Instabox",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "integra2-ftp",
			"name": "Integra2",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "intel-valley",
			"name": "Intel-Valley Supply chain (ShenZhen) Co. Ltd",
			"other_name": "智谷供应链（深圳）有限公司",
			"required_fields": []
		},
		{
			"slug": "intelipost",
			"name": "Intelipost (TMS for LATAM)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "interlink-express",
			"name": "DPD Local",
			"other_name": "Interlink UK",
			"required_fields": []
		},
		{
			"slug": "interlink-express-reference",
			"name": "DPD Local reference",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "international-seur",
			"name": "International Seur",
			"other_name": "SEUR Internacional",
			"required_fields": []
		},
		{
			"slug": "international-seur-api",
			"name": "International Seur API",
			"other_name": null,
			"required_fields": [
				"tracking_ship_date"
			]
		},
		{
			"slug": "interparcel-au",
			"name": "Interparcel Australia",
			"other_name": "Interparcel",
			"required_fields": []
		},
		{
			"slug": "interparcel-nz",
			"name": "Interparcel New Zealand",
			"other_name": "Interparcel",
			"required_fields": []
		},
		{
			"slug": "interparcel-uk",
			"name": "Interparcel UK",
			"other_name": "Interparcel",
			"required_fields": []
		},
		{
			"slug": "intex-de",
			"name": "INTEX Paketdienst GmbH",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "intexpress",
			"name": "Internet Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "intime-ftp",
			"name": "InTime",
			"other_name": null,
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
			"slug": "ivoy-webhook",
			"name": "Ivoy",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "j-net",
			"name": "J-Net",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jam-express",
			"name": "Jam Express",
			"other_name": "JAM Global Express",
			"required_fields": []
		},
		{
			"slug": "janco",
			"name": "Janco Ecommerce",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "janio",
			"name": "Janio Asia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "japan-post",
			"name": "Japan Post",
			"other_name": "日本郵便",
			"required_fields": []
		},
		{
			"slug": "javit",
			"name": "Javit",
			"other_name": null,
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
			"slug": "jd-express",
			"name": "京东物流",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "jd-worldwide",
			"name": "JD Worldwide",
			"other_name": "京东国际物流",
			"required_fields": []
		},
		{
			"slug": "jersey-post",
			"name": "Jersey Post",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jet-ship",
			"name": "Jet-Ship Worldwide",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jindouyun",
			"name": "金斗云物流",
			"other_name": "JINDOUYUN LOGISTICS",
			"required_fields": []
		},
		{
			"slug": "jinsung",
			"name": "JINSUNG TRADING",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jne",
			"name": "JNE",
			"other_name": "Express Across Nation, Tiki Jalur Nugraha Ekakurir",
			"required_fields": []
		},
		{
			"slug": "jne-api",
			"name": "JNE (API)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jocom",
			"name": "Jocom",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "joom-logistics",
			"name": "Joom Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "joyingbox",
			"name": "Joying Box",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "js-express",
			"name": "JS EXPRESS",
			"other_name": "急速物流",
			"required_fields": []
		},
		{
			"slug": "jt-logistics",
			"name": "J&T International logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "jtcargo",
			"name": "J&T CARGO",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "jtexpress",
			"name": "J&T EXPRESS MALAYSIA",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "jtexpress-vn",
			"name": "J&T Express Vietnam",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "jx",
			"name": "JX",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "k1-express",
			"name": "K1 Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kangaroo-my",
			"name": "Kangaroo Worldwide Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kargomkolay",
			"name": "KargomKolay (CargoMini)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "kdexp",
			"name": "Kyungdong Parcel",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "kec",
			"name": "KEC",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kedaex",
			"name": "KedaEX",
			"other_name": "KedaEx",
			"required_fields": []
		},
		{
			"slug": "kerry-ecommerce",
			"name": "Kerry eCommerce",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kerry-express-th-webhook",
			"name": "Kerry Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "kerry-logistics",
			"name": "Kerry Express Thailand",
			"other_name": "嘉里物流, Kerry Logistics",
			"required_fields": []
		},
		{
			"slug": "kerrytj",
			"name": "Kerry TJ Logistics",
			"other_name": "KTJ嘉里大榮物流",
			"required_fields": []
		},
		{
			"slug": "kerryttc-vn",
			"name": "Kerry Express (Vietnam) Co Ltd",
			"other_name": "KTTC",
			"required_fields": []
		},
		{
			"slug": "kgmhub",
			"name": "KGM Hub",
			"other_name": "KGM",
			"required_fields": []
		},
		{
			"slug": "kiala",
			"name": "Kiala",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kn",
			"name": "Kuehne + Nagel",
			"other_name": "KN",
			"required_fields": []
		},
		{
			"slug": "kng",
			"name": "Keuhne + Nagel Global",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "komon-express",
			"name": "Komon Express",
			"other_name": "深圳市可蒙国际物流有限公司",
			"required_fields": []
		},
		{
			"slug": "korea-post",
			"name": "Korea Post EMS",
			"other_name": "우정사업본부",
			"required_fields": []
		},
		{
			"slug": "kpost",
			"name": "Korea Post",
			"other_name": "우정사업본부",
			"required_fields": []
		},
		{
			"slug": "kronos",
			"name": "Kronos Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kurasi",
			"name": "KURASI",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kwe-global",
			"name": "KWE Global",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "kwt",
			"name": "Shenzhen Jinghuada Logistics Co., Ltd",
			"other_name": "KWT",
			"required_fields": []
		},
		{
			"slug": "ky-express",
			"name": "Kua Yue Express",
			"other_name": "KYE",
			"required_fields": []
		},
		{
			"slug": "la-poste-colissimo",
			"name": "La Poste",
			"other_name": "Coliposte",
			"required_fields": []
		},
		{
			"slug": "lalamove",
			"name": "Lalamove",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "lalamove-api",
			"name": "Lalamove",
			"other_name": "Lalamove",
			"required_fields": []
		},
		{
			"slug": "landmark-global",
			"name": "Landmark Global",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "lao-post",
			"name": "Lao Post",
			"other_name": "Laos Postal Service",
			"required_fields": []
		},
		{
			"slug": "lasership",
			"name": "LaserShip",
			"other_name": "LaserShip",
			"required_fields": []
		},
		{
			"slug": "latvijas-pasts",
			"name": "Latvijas Pasts",
			"other_name": "Latvijas Pasts",
			"required_fields": []
		},
		{
			"slug": "lbcexpress-api",
			"name": "LBC EXPRESS INC.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "lbcexpress-ftp",
			"name": "LBC EXPRESS INC.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "lctbr-api",
			"name": "LCT do Brasil",
			"other_name": "LCT do Brasil",
			"required_fields": []
		},
		{
			"slug": "leader",
			"name": "Leader",
			"other_name": "立德国际物流",
			"required_fields": []
		},
		{
			"slug": "legion-express",
			"name": "Legion Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "lexship",
			"name": "LexShip",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "lht-express",
			"name": "LHT Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "liccardi-express",
			"name": "LICCARDI EXPRESS COURIER",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "liefery",
			"name": "liefery",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "lietuvos-pastas",
			"name": "Lietuvos Paštas",
			"other_name": "Lithuania Post, LP Express",
			"required_fields": []
		},
		{
			"slug": "line",
			"name": "Line Clear Express & Logistics Sdn Bhd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "linkbridge",
			"name": "Link Bridge(BeiJing)international logistics co.,ltd",
			"other_name": "联博瑞翔（北京）国际物流股份有限公司",
			"required_fields": []
		},
		{
			"slug": "lion-parcel",
			"name": "Lion Parcel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "livrapide",
			"name": "Livrapide",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "locus-webhook",
			"name": "Locus",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "loggi",
			"name": "Loggi",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "loginext-webhook",
			"name": "T&W Delivery",
			"other_name": "T&W Delivery",
			"required_fields": []
		},
		{
			"slug": "logisters",
			"name": "Logisters",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "logistika",
			"name": "Logistika",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "logistyx-transgroup",
			"name": "Transgroup",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "logisystems-sftp",
			"name": "Kiitäjät",
			"other_name": "LogiSystems",
			"required_fields": []
		},
		{
			"slug": "logwin-logistics",
			"name": "Logwin Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "logysto",
			"name": "Logysto",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "lonestar",
			"name": "Lone Star Overnight",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "loomis-express",
			"name": "Loomis Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "lotte",
			"name": "Lotte Global Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ltianexp",
			"name": "LTIAN EXP",
			"other_name": "乐天国际",
			"required_fields": []
		},
		{
			"slug": "ltl",
			"name": "LTL",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "luwjistik",
			"name": "Luwjistik",
			"other_name": "Luwjistik",
			"required_fields": []
		},
		{
			"slug": "lwe-hk",
			"name": "Logistic Worldwide Express",
			"other_name": "LWE",
			"required_fields": []
		},
		{
			"slug": "m-xpress",
			"name": "M Xpress Sdn Bhd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "m3logistics",
			"name": "M3 Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mail-box-etc",
			"name": "Mail Boxes Etc.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mailamericas",
			"name": "MailAmericas",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mailplus",
			"name": "MailPlus",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mailplus-jp",
			"name": "MailPlus (Japan)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mainfreight",
			"name": "Mainfreight",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mainway",
			"name": "Mainway",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "malaysia-post",
			"name": "Malaysia Post EMS / Pos Laju",
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
			"slug": "malca-amit",
			"name": "Malca-Amit",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "malca-amit-api",
			"name": "Malca Amit",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mara-xpress",
			"name": "Mara Xpress",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "marken",
			"name": "Marken",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "matdespatch",
			"name": "Matdespatch",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "matkahuolto",
			"name": "Matkahuolto",
			"other_name": "Oy Matkahuolto Ab",
			"required_fields": []
		},
		{
			"slug": "mazet",
			"name": "Groupe Mazet",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mbw",
			"name": "MBW Courier Inc.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "meest",
			"name": "Meest",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mensajerosurbanos-api",
			"name": "Mensajeros Urbanos",
			"other_name": null,
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
			"slug": "mglobal",
			"name": "PT MGLOBAL LOGISTICS INDONESIA",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mhi",
			"name": "Mhi",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mikropakket",
			"name": "Mikropakket",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "mikropakket-be",
			"name": "Mikropakket Belgium",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "milkman",
			"name": "Milkman",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "misumi-cn",
			"name": "MISUMI Group Inc.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mnx",
			"name": "MNX",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mobi-br",
			"name": "Mobi Logistica",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mondialrelay",
			"name": "Mondial Relay",
			"other_name": "Mondial Relay France",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "mondialrelay-es",
			"name": "Mondial Relay Spain(Punto Pack)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mondialrelay-fr",
			"name": "Mondial Relay France",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "moova",
			"name": "Moova",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "morelink",
			"name": "Morelink",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "morning-express",
			"name": "Morning Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "morninglobal",
			"name": "Morning Global",
			"other_name": "Morning Global",
			"required_fields": []
		},
		{
			"slug": "mrw-ftp",
			"name": "MRW",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mrw-spain",
			"name": "MRW",
			"other_name": "MRW Spain",
			"required_fields": []
		},
		{
			"slug": "mudita",
			"name": "MUDITA",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "mwd-api",
			"name": "Metropolitan Warehouse & Delivery",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "mx-cargo",
			"name": "M&X cargo",
			"other_name": "M&X International Shipping Agency Co.,LTD",
			"required_fields": []
		},
		{
			"slug": "mydynalogic",
			"name": "My DynaLogic",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "myhermes-uk",
			"name": "EVRi",
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
			"slug": "nacex",
			"name": "NACEX",
			"other_name": "",
			"required_fields": [
				"tracking_account_number"
			]
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
			"slug": "nacex-spain-reference",
			"name": "NACEX Spain",
			"other_name": null,
			"required_fields": [
				"tracking_account_number",
				"tracking_key"
			]
		},
		{
			"slug": "naeko-ftp",
			"name": "Naeko Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "nanjingwoyuan",
			"name": "Nanjing Woyuan",
			"other_name": "nanjingwoyuan",
			"required_fields": []
		},
		{
			"slug": "naqel-express",
			"name": "Naqel Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "national-sameday",
			"name": "National Sameday",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "nationex",
			"name": "Nationex",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "nationwide-my",
			"name": "Nationwide Express",
			"other_name": "nationwide2u",
			"required_fields": []
		},
		{
			"slug": "new-zealand-post",
			"name": "New Zealand Post",
			"other_name": "NZ Post",
			"required_fields": []
		},
		{
			"slug": "neway",
			"name": "Neway Transport",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "neweggexpress",
			"name": "Newegg Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "newgistics",
			"name": "Newgistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "newgisticsapi",
			"name": "Newgistics API",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "newzealand-couriers",
			"name": "New Zealand Couriers",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "nhans-solutions",
			"name": "Nhans Solutions",
			"other_name": "Nhans Courier",
			"required_fields": []
		},
		{
			"slug": "nightline",
			"name": "Nightline",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "nim-express",
			"name": "Nim Express",
			"other_name": "Armadillio Express",
			"required_fields": []
		},
		{
			"slug": "nimbuspost",
			"name": "NimbusPost",
			"other_name": "NimbusPost",
			"required_fields": []
		},
		{
			"slug": "ninjavan",
			"name": "Ninja Van",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ninjavan-id",
			"name": "Ninja Van Indonesia",
			"other_name": "NinjaVan Indonesia",
			"required_fields": []
		},
		{
			"slug": "ninjavan-my",
			"name": "Ninja Van Malaysia",
			"other_name": "NinjaVan MY",
			"required_fields": []
		},
		{
			"slug": "ninjavan-thai",
			"name": "Ninja Van Thailand",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ninjavan-webhook",
			"name": "Ninjavan Webhook",
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
			"slug": "nippon-express",
			"name": "Nippon Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "nmtransfer",
			"name": "N&M Transfer Co., Inc.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "norsk-global",
			"name": "Norsk Global",
			"other_name": "Norsk European Wholesale",
			"required_fields": []
		},
		{
			"slug": "nova-poshta",
			"name": "Nova Poshta",
			"other_name": "Новая Почта",
			"required_fields": []
		},
		{
			"slug": "nova-poshta-api",
			"name": "Nova Poshta API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "nova-poshtaint",
			"name": "Nova Poshta (International)",
			"other_name": "Новая Почта",
			"required_fields": []
		},
		{
			"slug": "novofarma-webhook",
			"name": "Novofarma",
			"other_name": "Novofarma",
			"required_fields": []
		},
		{
			"slug": "nowlog-api",
			"name": "Sequoialog",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "nox-nachtexpress",
			"name": "Innight Express Germany GmbH (nox NachtExpress)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "nox-night-time-express",
			"name": "NOX NightTimeExpress",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "ntl",
			"name": "NTL logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ntlogistics-vn",
			"name": "Nhat Tin Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "nytlogistics",
			"name": "NYT SUPPLY CHAIN LOGISTICS Co.,LTD",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "oca-ar",
			"name": "OCA Argentina",
			"other_name": "OCA e-Pak",
			"required_fields": []
		},
		{
			"slug": "ocs",
			"name": "OCS ANA Group",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ocs-worldwide",
			"name": "OCS WORLDWIDE",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ohi-webhook",
			"name": "Ohi",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "okayparcel",
			"name": "OkayParcel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "old-dominion",
			"name": "Old Dominion Freight Line",
			"other_name": "ODFL",
			"required_fields": []
		},
		{
			"slug": "omlogistics-api",
			"name": "OM LOGISTICS LTD",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "omniparcel",
			"name": "Omni Parcel",
			"other_name": "Omni-Channel Logistics (Seko)",
			"required_fields": []
		},
		{
			"slug": "omnirps-webhook",
			"name": "Omni Returns",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "omniva",
			"name": "Omniva",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "oneclick",
			"name": "One click delivery services",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "oneworldexpress",
			"name": "One World Express",
			"other_name": "One World Express",
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
			"name": "FedEx® Poland Domestic",
			"other_name": "OPEK",
			"required_fields": []
		},
		{
			"slug": "orangeconnex",
			"name": "Orange Connex",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "orangedsinc",
			"name": "OrangeDS (Orange Distribution Solutions Inc)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "osm-worldwide",
			"name": "OSM Worldwide",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "osm-worldwide-sftp",
			"name": "OSM Worldwide",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "overseas-hr",
			"name": "Overseas Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "paack-webhook",
			"name": "Paack",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "packfleet",
			"name": "PACKFLEET",
			"other_name": "PACKFLEET",
			"required_fields": []
		},
		{
			"slug": "packlink",
			"name": "Packlink",
			"other_name": "Packlink Spain",
			"required_fields": []
		},
		{
			"slug": "packs",
			"name": "Packs",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "padtf",
			"name": "平安达腾飞快递",
			"other_name": "PAD",
			"required_fields": []
		},
		{
			"slug": "palexpress",
			"name": "PAL Express Limited",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pallet-network",
			"name": "The Pallet Network",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "palletways",
			"name": "Palletways",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "pan-asia",
			"name": "Pan-Asia International",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pandago-api",
			"name": "Pandago",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pandion",
			"name": "Pandion",
			"other_name": null,
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
			"required_fields": []
		},
		{
			"slug": "panther-order-number",
			"name": "Panther Order Number",
			"other_name": "Panther Group UK",
			"required_fields": []
		},
		{
			"slug": "panther-reference",
			"name": "Panther Reference",
			"other_name": "Panther Group UK",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "panther-reference-api",
			"name": "Panther Reference",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "paper-express",
			"name": "Paper Express",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "paperfly",
			"name": "Paperfly Private Limited",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "paquetexpress",
			"name": "Paquetexpress",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "parcel-force",
			"name": "Parcel Force",
			"other_name": "Parcelforce UK",
			"required_fields": []
		},
		{
			"slug": "parcel2go",
			"name": "Parcel2Go",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "parcelinklogistics",
			"name": "Parcelink Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "parcelled-in",
			"name": "Parcelled.in",
			"other_name": "Parcelled",
			"required_fields": []
		},
		{
			"slug": "parcelone",
			"name": "PARCEL ONE",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "parcelpal-webhook",
			"name": "ParcelPal",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "parcelpoint",
			"name": "ParcelPoint Pty Ltd",
			"other_name": "",
			"required_fields": [
				"tracking_key"
			]
		},
		{
			"slug": "parcelpost-sg",
			"name": "Parcel Post Singapore",
			"other_name": "ParcelPost",
			"required_fields": []
		},
		{
			"slug": "parcelright",
			"name": "Parcel Right",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "parceltopost",
			"name": "Parcel To Post",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "parcll",
			"name": "PARCLL",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "parknparcel",
			"name": "Park N Parcel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "passportshipping",
			"name": "Passport Shipping",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "patheon",
			"name": "Patheon Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "payo",
			"name": "Payo",
			"other_name": "Agila",
			"required_fields": []
		},
		{
			"slug": "pb-uspsflats-ftp",
			"name": "USPS Flats (Pitney Bowes)",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pcfcorp",
			"name": "PCF Final Mile",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pchome-api",
			"name": "網家速配股份有限公司",
			"other_name": "Pchome Express",
			"required_fields": []
		},
		{
			"slug": "pfcexpress",
			"name": "PFC Express",
			"other_name": "pfcexpress",
			"required_fields": []
		},
		{
			"slug": "pflogistics",
			"name": "PFL",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pgeon-api",
			"name": "Pgeon",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pickrr",
			"name": "Pickrr",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pickup",
			"name": "Pickupp",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pickupp-mys",
			"name": "PICK UPP",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pickupp-sgp",
			"name": "PICK UPP (Singapore)",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pidge",
			"name": "Pidge",
			"other_name": "Pidge",
			"required_fields": []
		},
		{
			"slug": "pil-logistics",
			"name": "PIL Logistics (China) Co., Ltd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pilot-freight",
			"name": "Pilot Freight Services",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pitney-bowes",
			"name": "Pitney Bowes",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pittohio",
			"name": "PITT OHIO",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pixsell",
			"name": "PIXSELL LOGISTICS",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "planzer",
			"name": "Planzer Group",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "plusuk-webhook",
			"name": "Plus UK Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "plycongroup",
			"name": "Plycon Transportation Group",
			"other_name": "Plycon Transportation Group",
			"required_fields": []
		},
		{
			"slug": "poczta-polska",
			"name": "Poczta Polska",
			"other_name": "Poland Post",
			"required_fields": []
		},
		{
			"slug": "polarspeed",
			"name": "PolarSpeed Inc",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pony-express",
			"name": "Pony express",
			"other_name": "",
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
			"slug": "post-serbia",
			"name": "Post Serbia",
			"other_name": "Pou0161ta Srbije",
			"required_fields": []
		},
		{
			"slug": "post-slovenia",
			"name": "Post of Slovenia",
			"other_name": "",
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
			"slug": "postaplus",
			"name": "Posta Plus",
			"other_name": "PostaPlus",
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
			"name": "Posti",
			"other_name": "Finland Post",
			"required_fields": []
		},
		{
			"slug": "posti-api",
			"name": "Posti API",
			"other_name": null,
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
			"slug": "postone",
			"name": "Post ONE",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "postplus",
			"name": "PostPlus",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "postur-is",
			"name": "Iceland Post",
			"other_name": "Postur.is, Íslandspóstur",
			"required_fields": []
		},
		{
			"slug": "ppbyb",
			"name": "PayPal Package",
			"other_name": "贝邮宝",
			"required_fields": []
		},
		{
			"slug": "ppl",
			"name": "Professional Parcel Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "pressiode",
			"name": "Pressio",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "procarrier",
			"name": "Pro Carrier",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "productcaregroup-sftp",
			"name": "Product Care Services Limited",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "professional-couriers",
			"name": "Professional Couriers",
			"other_name": "TPC India",
			"required_fields": []
		},
		{
			"slug": "promeddelivery",
			"name": "ProMed Delivery, Inc.",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "pts",
			"name": "PTS",
			"other_name": null,
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
			"slug": "purolator-international",
			"name": "Purolator International",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "qintl-api",
			"name": "Quickstat Courier LLC",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "quantium",
			"name": "Quantium",
			"other_name": "quantium",
			"required_fields": []
		},
		{
			"slug": "quiqup",
			"name": "Quiqup",
			"other_name": "Quiqup",
			"required_fields": []
		},
		{
			"slug": "qwintry",
			"name": "Qwintry Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "qxpress",
			"name": "Qxpress",
			"other_name": "Qxpress Qoo10",
			"required_fields": []
		},
		{
			"slug": "raben-group",
			"name": "Raben Group",
			"other_name": "myRaben",
			"required_fields": []
		},
		{
			"slug": "raf",
			"name": "RAF Philippines",
			"other_name": "RAF Int'l. Forwarding",
			"required_fields": []
		},
		{
			"slug": "raiderex",
			"name": "RaidereX",
			"other_name": "Detrack",
			"required_fields": []
		},
		{
			"slug": "ramgroup-za",
			"name": "RAM",
			"other_name": "RAM Group",
			"required_fields": []
		},
		{
			"slug": "ransa-webhook",
			"name": "Ransa",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "rcl",
			"name": "Red Carpet Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "redjepakketje",
			"name": "Red je Pakketje",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "redur-es",
			"name": "Redur Spain",
			"other_name": "Eurodis",
			"required_fields": []
		},
		{
			"slug": "reimaginedelivery",
			"name": "maergo",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "relaiscolis",
			"name": "Relais Colis",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "rhenus-group",
			"name": "Rhenus Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "rhenus-uk-api",
			"name": "Rhenus Logistics UK",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "rincos",
			"name": "Rincos",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "rixonhk-api",
			"name": "Rixon Logistics",
			"other_name": "Rixon Logistics",
			"required_fields": []
		},
		{
			"slug": "rl-carriers",
			"name": "RL Carriers",
			"other_name": "R+L Carriers",
			"required_fields": []
		},
		{
			"slug": "roadbull",
			"name": "Roadbull Logistics",
			"other_name": "Roadbull Logistics Pte Ltd",
			"required_fields": []
		},
		{
			"slug": "roadrunner-freight",
			"name": "Roadrunner Transport Service",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "rocketparcel",
			"name": "Rocket Parcel International",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "routific-webhook",
			"name": "Routific",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "royal-mail-ftp",
			"name": "Royal Mail",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "royalshipments",
			"name": "RoyalShipments",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "rpd2man",
			"name": "RPD2man Deliveries",
			"other_name": "RPD-2man",
			"required_fields": []
		},
		{
			"slug": "rpx",
			"name": "RPX Indonesia",
			"other_name": "Repex Perdana International",
			"required_fields": []
		},
		{
			"slug": "rpxlogistics",
			"name": "RPX Logistics",
			"other_name": "",
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
			"slug": "ruston",
			"name": "Ruston",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "rzyexpress",
			"name": "RZY Express",
			"other_name": "RZYExpress",
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
			"slug": "sagawa-api",
			"name": "Sagawa",
			"other_name": "佐川急便",
			"required_fields": []
		},
		{
			"slug": "saia-freight",
			"name": "Saia LTL Freight",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sailpost",
			"name": "SAILPOST SPA",
			"other_name": "SAILPOST SPA",
			"required_fields": []
		},
		{
			"slug": "sap-express",
			"name": "SAP EXPRESS",
			"other_name": "",
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
			"slug": "sberlogistics-ru",
			"name": "Sber Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "scudex-express",
			"name": "Scudex Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sdh-scm",
			"name": "闪电猴",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sefl",
			"name": "Southeastern Freight Lines",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "seino",
			"name": "Seino",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "seino-api",
			"name": "Seino",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "seko-sftp",
			"name": "SEKO Worldwide, LLC",
			"other_name": "SEKO Logistics",
			"required_fields": []
		},
		{
			"slug": "sekologistics",
			"name": "SEKO Logistics",
			"other_name": "SEKO",
			"required_fields": []
		},
		{
			"slug": "sending",
			"name": "Sending Transporte Urgente y Comunicacion, S.A.U",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sendit",
			"name": "Sendit",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sendle",
			"name": "Sendle",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "servip-webhook",
			"name": "SerVIP",
			"other_name": "SerVIP",
			"required_fields": []
		},
		{
			"slug": "setel",
			"name": "Setel Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sf-express",
			"name": "SF Express",
			"other_name": "順豊快遞, SF",
			"required_fields": []
		},
		{
			"slug": "sf-express-cn",
			"name": "SF Express China",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sfb2c",
			"name": "SF International",
			"other_name": "順豐國際",
			"required_fields": []
		},
		{
			"slug": "sfc",
			"name": "SFC",
			"other_name": "三态速递",
			"required_fields": []
		},
		{
			"slug": "sfcservice",
			"name": "SFC-SendfromChina",
			"other_name": "sfcservice",
			"required_fields": []
		},
		{
			"slug": "sfplus-webhook",
			"name": "Zeek",
			"other_name": "Kin Shun Information Technology Limited",
			"required_fields": []
		},
		{
			"slug": "shadowfax",
			"name": "Shadowfax",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sherpa",
			"name": "Sherpa",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "ship-it-asia",
			"name": "Ship It Asia",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shipa",
			"name": "SHIPA",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shipentegra",
			"name": "ShipEntegra",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shipgate",
			"name": "ShipGate",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shippie",
			"name": "Shippie",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shippify",
			"name": "Shippify, Inc",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shippit",
			"name": "Shippit",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shiprocket",
			"name": "Shiprocket X",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shipter",
			"name": "SHIPTER",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shiptor",
			"name": "Shiptor",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shipwestgate",
			"name": "Westgate Global",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shipx",
			"name": "ShipX",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shopfans",
			"name": "ShopfansRU LLC",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shopolive",
			"name": "Olive",
			"other_name": "Olive",
			"required_fields": []
		},
		{
			"slug": "showl",
			"name": "SENHONG INTERNATIONAL LOGISTICS",
			"other_name": "森鸿国际物流",
			"required_fields": []
		},
		{
			"slug": "shree-maruti",
			"name": "Shree Maruti Courier Services Pvt Ltd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shreeanjanicourier",
			"name": "Shree Anjani Courier",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shreenandancourier",
			"name": "SHREE NANDAN COURIER",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "shreetirupati",
			"name": "SHREE TIRUPATI COURIER SERVICES PVT. LTD.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "shunbang-express",
			"name": "ShunBang Express",
			"other_name": "Shun Bang Express",
			"required_fields": []
		},
		{
			"slug": "shyplite",
			"name": "Shypmax",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sic-teliway",
			"name": "Teliway SIC Express",
			"other_name": "Prevote",
			"required_fields": []
		},
		{
			"slug": "simpletire-webhook",
			"name": "SimpleTire",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "simplypost",
			"name": "J&T Express Singapore",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "simsglobal",
			"name": "Sims Global",
			"other_name": "Sims Partner",
			"required_fields": []
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
			"slug": "singlobal-express",
			"name": "Sin Global Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sinotrans",
			"name": "Sinotrans",
			"other_name": "中外运跨境电商物流有限公司",
			"required_fields": []
		},
		{
			"slug": "siodemka",
			"name": "Siodemka",
			"other_name": "Siodemka Kurier",
			"required_fields": []
		},
		{
			"slug": "sk-posta",
			"name": "Slovenská pošta, a.s.",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sky-postal",
			"name": "SkyPostal",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "skybox",
			"name": "SKYBOX",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "skynet",
			"name": "SkyNet Malaysia",
			"other_name": "SkyNet MY",
			"required_fields": []
		},
		{
			"slug": "skynet-za",
			"name": "Skynet World Wide Express South Africa",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "skynetworldwide",
			"name": "SkyNet Worldwide Express",
			"other_name": "Skynetwwe",
			"required_fields": []
		},
		{
			"slug": "skynetworldwide-uae",
			"name": "SkyNet Worldwide Express UAE",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "skynetworldwide-uk",
			"name": "Skynet Worldwide Express UK",
			"other_name": "Skynet UK",
			"required_fields": []
		},
		{
			"slug": "smartcat",
			"name": "SMARTCAT",
			"other_name": "上海黑猫快运有限公司",
			"required_fields": []
		},
		{
			"slug": "smg-express",
			"name": "SMG Direct",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "smooth",
			"name": "Smooth Couriers",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "smsa-express",
			"name": "SMSA Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sntglobal-api",
			"name": "Snt Global Etrax",
			"other_name": "Ship n track Etrax",
			"required_fields": []
		},
		{
			"slug": "solistica-api",
			"name": "solistica",
			"other_name": "solistica",
			"required_fields": []
		},
		{
			"slug": "sonictl",
			"name": "Sonic Transportation & Logistics",
			"other_name": "",
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
			"slug": "spanish-seur-api",
			"name": "Spanish Seur API",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "spanish-seur-ftp",
			"name": "Spanish Seur",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "specialisedfreight-za",
			"name": "Specialised Freight",
			"other_name": "SFS",
			"required_fields": []
		},
		{
			"slug": "spectran",
			"name": "Spectran",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "speedcouriers-gr",
			"name": "Speed Couriers",
			"other_name": "Speed Couriers",
			"required_fields": []
		},
		{
			"slug": "speedee",
			"name": "Spee-Dee Delivery",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "speedex",
			"name": "SPEEDEX",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "speedy",
			"name": "Speedy",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "spoton",
			"name": "SPOTON Logistics Pvt Ltd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "spreetail-api",
			"name": "Spreetail",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "spring-gds",
			"name": "Spring GDS",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sprint-pack",
			"name": "SPRINT PACK",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "spx",
			"name": "Shopee Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "spx-th",
			"name": "Shopee Xpress",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "srekorea",
			"name": "SRE Korea",
			"other_name": "SRE 배송서비스",
			"required_fields": []
		},
		{
			"slug": "srt-transport",
			"name": "SRT Transport",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "stallionexpress",
			"name": "Stallion Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "star-track",
			"name": "StarTrack",
			"other_name": "Star Track",
			"required_fields": []
		},
		{
			"slug": "star-track-courier",
			"name": "Star Track Courier",
			"other_name": "",
			"required_fields": [
				"tracking_state"
			]
		},
		{
			"slug": "star-track-express",
			"name": "Star Track Express",
			"other_name": "AaE Australian air Express",
			"required_fields": []
		},
		{
			"slug": "star-track-webhook",
			"name": "StarTrack",
			"other_name": "Star Track",
			"required_fields": []
		},
		{
			"slug": "starken",
			"name": "STARKEN",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "statovernight",
			"name": "Stat Overnight",
			"other_name": "Stat Overnight",
			"required_fields": []
		},
		{
			"slug": "stepforwardfs",
			"name": "STEP FORWARD FREIGHT SERVICE CO LTD",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sto",
			"name": "STO Express",
			"other_name": "申通快递, Shentong Express",
			"required_fields": []
		},
		{
			"slug": "stone3pl",
			"name": "STONE3PL",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "streck-transport",
			"name": "Streck Transport",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sutton",
			"name": "Sutton Transport",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "sweden-posten",
			"name": "PostNord Sweden",
			"other_name": "Sweden Post, Posten, Sweden Posten",
			"required_fields": []
		},
		{
			"slug": "swiship",
			"name": "Swiship",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "swiss-post",
			"name": "Swiss Post",
			"other_name": "La Poste Suisse, Die Schweizerische Post, Die Post",
			"required_fields": []
		},
		{
			"slug": "swiss-post-ftp",
			"name": "Swiss Post FTP",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "sypost",
			"name": "Sunyou Post",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "szdpex",
			"name": "DPEX China",
			"other_name": "DPEX（深圳）国际物流, Toll China",
			"required_fields": []
		},
		{
			"slug": "szendex",
			"name": "SZENDEX",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "taiwan-post",
			"name": "Taiwan Post",
			"other_name": "Chunghwa Post, 台灣中華郵政",
			"required_fields": []
		},
		{
			"slug": "tamergroup-webhook",
			"name": "Tamer Logistics",
			"other_name": "Tamer Logistics",
			"required_fields": []
		},
		{
			"slug": "tanet",
			"name": "Transport Ambientales",
			"other_name": "tanet",
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
			"name": "Yamato Singapore",
			"other_name": "Yamato Singapore",
			"required_fields": []
		},
		{
			"slug": "taqbin-sg-api",
			"name": "Yamato Singapore",
			"other_name": "Yamato Singapore",
			"required_fields": []
		},
		{
			"slug": "taqbin-taiwan",
			"name": "PRESIDENT TRANSNET CORP",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tarrive",
			"name": "TONDA GLOBAL",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "taxydromiki",
			"name": "Geniki Taxydromiki",
			"other_name": "ΓΕΝΙΚΗ ΤΑΧΥΔΡΟΜΙΚΗ",
			"required_fields": []
		},
		{
			"slug": "tazmanian-freight",
			"name": "Tazmanian Freight Systems",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tck-express",
			"name": "TCK Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tcs",
			"name": "TCS",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "teleport-webhook",
			"name": "Teleport",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "testing-courier",
			"name": "Testing Courier",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "testing-courier-webhook",
			"name": "Testing Courier",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tfm",
			"name": "TFM Xpress",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "tforce-finalmile",
			"name": "TForce Final Mile",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tgx",
			"name": "Kerry Express Hong Kong",
			"other_name": "Top Gun Express, 精英速運, TGX",
			"required_fields": []
		},
		{
			"slug": "thabit-logistics",
			"name": "Thabit Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "thailand-post",
			"name": "Thailand Thai Post",
			"other_name": "ไปรษณีย์ไทย",
			"required_fields": []
		},
		{
			"slug": "thaiparcels",
			"name": "TP Logistic",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "thecourierguy",
			"name": "The Courier Guy",
			"other_name": "TheCourierGuy",
			"required_fields": []
		},
		{
			"slug": "thedeliverygroup",
			"name": "TDG – The Delivery Group",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "thenile-webhook",
			"name": "SortHub",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "thijs-nl",
			"name": "Thijs Logistiek",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tigfreight",
			"name": "TIG Freight",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tiki",
			"name": "Tiki",
			"other_name": "Citra Van Titipan Kilat",
			"required_fields": []
		},
		{
			"slug": "tipsa",
			"name": "TIPSA",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tipsa-api",
			"name": "Tipsa API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tipsa-ref",
			"name": "Tipsa Reference",
			"other_name": null,
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
			"slug": "tnt-fr-reference",
			"name": "TNT France Reference",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tnt-it",
			"name": "TNT Italy",
			"other_name": "TNT Express IT",
			"required_fields": []
		},
		{
			"slug": "tnt-reference",
			"name": "TNT Reference",
			"other_name": "TNT consignment reference",
			"required_fields": []
		},
		{
			"slug": "tnt-uk",
			"name": "TNT UK",
			"other_name": "TNT United Kingdom",
			"required_fields": []
		},
		{
			"slug": "tnt-uk-reference",
			"name": "TNT UK Reference",
			"other_name": "TNT UK consignment reference",
			"required_fields": []
		},
		{
			"slug": "tntpost-it",
			"name": "Nexive (TNT Post Italy)",
			"other_name": "Postnl TNT",
			"required_fields": []
		},
		{
			"slug": "toll-ipec",
			"name": "Toll IPEC",
			"other_name": "Toll Express",
			"required_fields": []
		},
		{
			"slug": "toll-nz",
			"name": "Toll New Zealand",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "toll-priority",
			"name": "Toll Priority",
			"other_name": "Toll Group, Toll Priority",
			"required_fields": []
		},
		{
			"slug": "toll-webhook",
			"name": "Toll Group",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tolos",
			"name": "Tolos",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tomydoor",
			"name": "Tomydoor",
			"other_name": "Tomydoor",
			"required_fields": []
		},
		{
			"slug": "tonami-ftp",
			"name": "Tonami",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tophatterexpress",
			"name": "Tophatter Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "topyou",
			"name": "TopYou",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "total-express",
			"name": "Total Express",
			"other_name": "",
			"required_fields": [
				"tracking_account_number"
			]
		},
		{
			"slug": "total-express-api",
			"name": "Total Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "tourline",
			"name": "CTT Express",
			"other_name": "ctt",
			"required_fields": []
		},
		{
			"slug": "tourline-reference",
			"name": "Tourline Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "trackon",
			"name": "Trackon Couriers Pvt. Ltd",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "trakpak",
			"name": "P2P TrakPak",
			"other_name": "bpost international P2P Mailing Trak Pak",
			"required_fields": []
		},
		{
			"slug": "trans-kargo",
			"name": "Trans Kargo Internasional",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "trans2u",
			"name": "Trans2u",
			"other_name": null,
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
			"slug": "transvirtual",
			"name": "TransVirtual",
			"other_name": "TransVirtual",
			"required_fields": []
		},
		{
			"slug": "trumpcard",
			"name": "TRUMPCARD LLC",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "trunkrs",
			"name": "Trunkrs",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "trunkrs-webhook",
			"name": "Trunkrs",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "tuffnells",
			"name": "Tuffnells Parcels Express",
			"other_name": "",
			"required_fields": [
				"tracking_account_number",
				"tracking_postal_code"
			]
		},
		{
			"slug": "tuffnells-reference",
			"name": "Tuffnells Parcels Express- Reference",
			"other_name": "",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "typ",
			"name": "TYP",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "u-envios",
			"name": "U-ENVIOS",
			"other_name": "U-ENVIOS",
			"required_fields": []
		},
		{
			"slug": "uber-webhook",
			"name": "Uber",
			"other_name": "Uber",
			"required_fields": []
		},
		{
			"slug": "ubi-logistics",
			"name": "UBI Smart Parcel",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "uc56",
			"name": "ucexpress",
			"other_name": "优速快递",
			"required_fields": []
		},
		{
			"slug": "ucs",
			"name": "UCS",
			"other_name": "合众速递",
			"required_fields": []
		},
		{
			"slug": "uds",
			"name": "United Delivery Service, Ltd",
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
			"slug": "uparcel",
			"name": "uParcel",
			"other_name": "uParcel",
			"required_fields": []
		},
		{
			"slug": "ups",
			"name": "UPS",
			"other_name": "United Parcel Service",
			"required_fields": []
		},
		{
			"slug": "ups-api",
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
			"slug": "ups-reference",
			"name": "UPS Reference",
			"other_name": "United Parcel Service",
			"required_fields": []
		},
		{
			"slug": "urgent-cargus",
			"name": "Urgent Cargus",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "usf-reddaway",
			"name": "USF Reddaway",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "uship",
			"name": "uShip",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "usps",
			"name": "USPS",
			"other_name": "United States Postal Service",
			"required_fields": []
		},
		{
			"slug": "usps-api",
			"name": "USPS API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "usps-webhook",
			"name": "USPS Informed Visibility - Webhook",
			"other_name": "USPS IV",
			"required_fields": []
		},
		{
			"slug": "value-webhook",
			"name": "Value Logistics",
			"other_name": "Value Logistics",
			"required_fields": []
		},
		{
			"slug": "vamox",
			"name": "VAMOX",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "venipak",
			"name": "Venipak",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "via-express",
			"name": "Viaxpress",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "viaeurope",
			"name": "ViaEurope",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "viaxpress",
			"name": "ViaXpress",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "viettelpost",
			"name": "ViettelPost",
			"other_name": "Bưu chính Viettel",
			"required_fields": []
		},
		{
			"slug": "virtransport",
			"name": "VIR Transport",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "virtransport-sftp",
			"name": "Vir Transport",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "viwo",
			"name": "VIWO IoT",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "vnpost",
			"name": "Vietnam Post",
			"other_name": "VNPost",
			"required_fields": []
		},
		{
			"slug": "vnpost-api",
			"name": "Vietnam Post",
			"other_name": null,
			"required_fields": [
				"tracking_ship_date"
			]
		},
		{
			"slug": "vox",
			"name": "VOX SOLUCION EMPRESARIAL SRL",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "wahana",
			"name": "Wahana",
			"other_name": "Wahana Indonesia",
			"required_fields": []
		},
		{
			"slug": "wanbexpress",
			"name": "WanbExpress",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "weaship",
			"name": "Weaship",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "wedo",
			"name": "WeDo Logistics",
			"other_name": "運德物流",
			"required_fields": []
		},
		{
			"slug": "wepost",
			"name": "WePost Sdn Bhd",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "weship",
			"name": "WeShip",
			"other_name": null,
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "weship-api",
			"name": "WeShip",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "westbank-courier",
			"name": "West Bank Courier",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "weworldexpress",
			"name": "We World Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "whistl",
			"name": "Whistl",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "whistl-sftp",
			"name": "Whistl",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "wineshipping-webhook",
			"name": "Wineshipping",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "winit",
			"name": "万邑通",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "wise-express",
			"name": "Wise Express",
			"other_name": "wiseexpress",
			"required_fields": []
		},
		{
			"slug": "wiseloads",
			"name": "Wiseloads",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "wish-email-push",
			"name": "Wish",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "wishpost",
			"name": "WishPost",
			"other_name": "Wish",
			"required_fields": []
		},
		{
			"slug": "wizmo",
			"name": "Wizmo",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "wndirect",
			"name": "wnDirect",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "worldcourier",
			"name": "World Courier",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "worldnet",
			"name": "Worldnet Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "wspexpress",
			"name": "WSP Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "wyngs-my",
			"name": "Wyngs",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "xde-webhook",
			"name": "Ximex Delivery Express",
			"other_name": null,
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
			"slug": "xdp-uk-reference",
			"name": "XDP Express Reference",
			"other_name": "XDP UK",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "xl-express",
			"name": "XL Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "xpedigo",
			"name": "Xpedigo",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "xpert-delivery",
			"name": "Xpert Delivery",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "xpo-logistics",
			"name": "XPO",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "xpost",
			"name": "Xpost.ph",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "xpressbees",
			"name": "XpressBees",
			"other_name": "XpressBees logistics",
			"required_fields": []
		},
		{
			"slug": "xpressen-dk",
			"name": "Xpressen",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "xq-express",
			"name": "XQ Express",
			"other_name": "xq-express",
			"required_fields": []
		},
		{
			"slug": "xyy",
			"name": "Xingyunyi Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "yakit",
			"name": "Yakit",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "yanwen",
			"name": "Yanwen",
			"other_name": "燕文物流",
			"required_fields": []
		},
		{
			"slug": "ydex",
			"name": "Shenzhen 1st International Logistics(Group)Co,Ltd",
			"other_name": "深圳市一代国际物流（集团）有限公司",
			"required_fields": []
		},
		{
			"slug": "ydh-express",
			"name": "YDH express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "yifan",
			"name": "YiFan Express",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "yingnuo-logistics",
			"name": "英诺供应链",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "yodel",
			"name": "Yodel Domestic",
			"other_name": "Home Delivery Network Limited (HDNL)",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "yodel-api",
			"name": "Yodel API",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "yodel-international",
			"name": "Yodel International",
			"other_name": "Home Delivery Network, HDNL",
			"required_fields": [
				"tracking_postal_code"
			]
		},
		{
			"slug": "yodeldirect",
			"name": "Yodel Direct",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "yrc",
			"name": "YRC",
			"other_name": "YRC Freight",
			"required_fields": []
		},
		{
			"slug": "yto",
			"name": "YTO Express",
			"other_name": "yto",
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
			"name": "YunExpress",
			"other_name": "云途物流",
			"required_fields": []
		},
		{
			"slug": "yurtici-kargo",
			"name": "Yurtici Kargo",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "yusen",
			"name": "Yusen Logistics",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "yusen-sftp",
			"name": "Yusen Logistics",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "yycom",
			"name": "HUAHANG EXPRESS",
			"other_name": "华航吉运",
			"required_fields": []
		},
		{
			"slug": "yyexpress",
			"name": "YYEXPRESS",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "zajil-express",
			"name": "Zajil Express Company",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "zeek",
			"name": "Zeek2Door",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "zeleris",
			"name": "Zeleris",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "zes-express",
			"name": "Eshun international Logistic",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "ziingfinalmile",
			"name": "Ziing",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "zinc",
			"name": "Zinc",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "zjs-express",
			"name": "ZJS International",
			"other_name": "宅急送快運",
			"required_fields": []
		},
		{
			"slug": "zto-domestic",
			"name": "ZTO Express China",
			"other_name": null,
			"required_fields": []
		},
		{
			"slug": "zto-express",
			"name": "ZTO Express",
			"other_name": "",
			"required_fields": []
		},
		{
			"slug": "zyllem",
			"name": "Zyllem",
			"other_name": "RocketUncle",
			"required_fields": []
		}
	];
	return data;
}
