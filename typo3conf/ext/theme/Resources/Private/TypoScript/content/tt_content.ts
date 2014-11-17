

# **********************************************************
# Changes of content element rendering
# **********************************************************

tt_content {

	# Every content element is wrapped inside a div
	stdWrap.outerWrap = <div class="element">|</div>


	stdWrap.innerWrap2.cObject = COA
	stdWrap.innerWrap2.cObject {
		10 = TEXT
		10 {
			value = |
		}

		20 = TEXT
		20 {
			wrap = <p class="csc-linkToTop no-print">|</p>
			data = LLL:EXT:css_styled_content/pi1/locallang.xml:general.toplink
			typolink {
				parameter.dataWrap = {getIndpEnv:TYPO3_REQUEST_URL}#top
			}
		}
	}
}


lib.stdheader.10.stdWrap.override {
	if {
		value = 21,22,23,24,25
		isInList.field = layout
	}
	cObject = TEXT
	cObject {
		field = header
		htmlSpecialChars = 1
		wrap = <h6 class="header">|</h6>
	}
}

#-------------------------------------------------------------------------------
#	Responsive images
#-------------------------------------------------------------------------------
_tt_content {
	image.20 {
		1.params = class="thumbnail"

		addClassesCol >
		addClassesCol.override.cObject = CASE
		addClassesCol.override.cObject {
			key.field = imagecols

			1 = TEXT
			1.value = col-sm-12
			2  = TEXT
			2.value = col-sm-6
			3 = TEXT
			3.value = col-sm-4
			4 = TEXT
			4.value= col-sm-3
			6 = TEXT
			6.value = col-sm-2

			default = TEXT
			default.value = col-sm-3
		}
		rendering {
			noCaption {
				rowStdWrap.wrap = <div class="row"> | </div>
				noRowsStdWrap.wrap = <div class="row csc-textpic-imagerow-none"> | </div>
				lastRowStdWrap.wrap = <div class="row csc-textpic-imagerow-last"> | </div>
				columnStdWrap.wrap = <div class="###CLASSES###"> | </div>
			}

			splitCaption {
				rowStdWrap.wrap = <div class="row"> | </div>
				noRowsStdWrap.wrap = <div class="row csc-textpic-imagerow-none"> | </div>
				lastRowStdWrap.wrap = <div class="row csc-textpic-imagerow-last"> | </div>
				columnStdWrap.wrap = <div class="###CLASSES###"> | </div>

				singleStdWrap.wrap.override = <figure class="thumbnail###CLASSES###">|###CAPTION###</figure>
				caption.wrap.override = <figcaption class="caption"> | </figcaption>
			}
		}
	}
}
