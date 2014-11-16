

# *******************************************************************
# Constants of the DEVELOPMENT mode
# !!! add everything to the production.ts and only those things
#     which differ to this section!
# *******************************************************************

plugin.theme_configuration {
	url = http://localhost/sites/t3/base/

	general {
		googleanalytics = 0
		pageTitle.prefix = !!DEV!! theme -
	}

	assets {
		merge = 0
		compress = 0
	}

	extensions {
		realurl = 1

		formhandler {
			contact {
				debug = 0
			}
		}
	}
}

