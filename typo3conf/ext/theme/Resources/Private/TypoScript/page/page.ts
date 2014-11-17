# **********************************************************
# General PAGE setup
#
# including template, CSS + JS files
# **********************************************************

page = PAGE
page {

	# Page template
	10 = FLUIDTEMPLATE
	10 {
		file.stdWrap.cObject = TEXT
		file.stdWrap.cObject {
			data = levelfield:-2,backend_layout_next_level,slide
			override.field = backend_layout
			split {
				token = file__
				1.current = 1
				1.wrap = |
			}
			ifEmpty = 1col
			wrap = EXT:theme/Resources/Private/Templates/|.html
		}
		layoutRootPath = EXT:theme/Resources/Private/Templates/Layouts/
		variables {

		}
	}

	# CSS files to be included
	includeCSS {
		file1 = EXT:theme/Resources/Public/Template/css/style.css
		file1.media = screen,print

		file2 = EXT:theme/Resources/Public/Template/css/print.css
		file2.media = print
	}

	# JS files to be included
	includeJSFooter {
		main = EXT:theme/Resources/Public/Template/js/bottom.js
    }

	includeJS {
		ie = EXT:theme/Resources/Public/Template/js/ie.js
		ie {
			allWrap = <!--[if lt IE 9]>|<![endif]-->
			excludeFromConcatenation = 1
			forceOnTop = 1
		}
		headerLibs = EXT:theme/Resources/Public/Template/js/top.js
    }

	bodyTagCObject = COA
	bodyTagCObject   {
		stdWrap.wrap = <body class="|">

			# Add page UID
			10 = TEXT
			10 {
				value = page-{field:uid}
				insertData = 1
				noTrimWrap = || |
			}

			# Add current language
			20 = TEXT
			20 {
				value = language-{TSFE:sys_language_uid} languagecontent-{TSFE:sys_language_content}
				insertData = 1
				noTrimWrap = || |
			}
			# Add level
			25 = TEXT
			25 {
				value = level-{level:0}
				insertData = 1
				noTrimWrap = || |
			}
			# Add backend-layout
			30 = TEXT
			30 {
				wrap = template-|
				data = levelfield:-1, backend_layout_next_level, slide
				override.field = backend_layout
				split {
					token = file__
					1.current = 1
					1.wrap = |
				}
			}

			# Add uid of optional FE-layout
			40 = TEXT
			40 {
				fieldRequired = layout
				value = layout-{field:layout}
				insertData = 1
				noTrimWrap = | ||
			}
	}

}

# **********************************************************
# Issue Collector, e.g. JIRA
# **********************************************************
[globalVar = TSFE : beUserLogin > 0]
	page.includeJS.issueCollector = {$plugin.theme_configuration.general.issueCollectorJsPath}
	page.includeJS.issueCollector {
		excludeFromConcatenation = 1
		external = 1
		disableCompression = 1
	}
[global]
