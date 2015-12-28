Photo = Class.create();

Photo.prototype = {
	initialize : function() {
		
		this.m_sSource 		= '';
		this.m_iRotate 		= null;
		this.m_iFlipH 		= null;
		this.m_iFlipV		= null;
		this.m_iEdgy		= null;
		this.m_iGreySchale	= null;
		this.m_iResizeW		= null;
		this.m_iResizeH		= null;
		this.m_iSketchy 	= null;
		this.m_iShadow 		= null;
		this.m_sCaption		= null;
		this.m_sFontFile 	= null;
		this.m_iFontSize 	= null;
		this.m_iChuck		= null;
		
	},
	load : function(p_sImage) {
		this.m_sSource = p_sImage;
		return this;				
	},
	fetch : function() {
		l_oElement = new Element('img', {
			src : 'image.php?'+this._joinOptions()
		});
		return l_oElement;
	},
	_joinOptions : function() {
		
		var l_aOptions 	= new Object();
		l_aOptions.i 	= this.m_sSource;
		l_aOptions.fh	= this.m_iFlipH;
		l_aOptions.fv	= this.m_iFlipV;
		l_aOptions.ed	= this.m_iEdgy;
		l_aOptions.gr	= this.m_iGreySchale;
		l_aOptions.rw	= this.m_iResizeW;
		l_aOptions.rh	= this.m_iResizeH;
		l_aOptions.sk	= this.m_iSketchy;
		l_aOptions.sh	= this.m_iShadow;
		l_aOptions.ct	= this.m_sCaption;
		l_aOptions.cf	= this.m_sFontFile;
		l_aOptions.cs	= this.m_iFontSize;
		l_aOptions.cn	= this.m_iChuck;
		
		if(this.m_iRotate) l_aOptions.r = this.m_iRotate;
		
		return Object.toQueryString(l_aOptions);
	},
	rotate : function(p_iDegrees) {
		this.m_iRotate = p_iDegrees;
		return this;
	},
	flipH : function() {
		this.m_iFlipH = 1;
		return this;
	},
	flipV : function() {
		this.m_iFlipV = 1;
		return this;
	},
	makeEdgy : function() {
		this.m_iEdgy = 1;
		return this;
	},
	toGreyScale : function() {
		this.m_iGreySchale = 1;
		return this;
	},
	resize : function(p_oDimensions) {
		if(p_oDimensions.width) this.m_iResizeW = p_oDimensions.width;
		if(p_oDimensions.height) this.m_iResizeH = p_oDimensions.height;
		return this;
	},
	makeSketchy : function() {
		this.m_iSketchy = 1;
		return this;
	},
	dropShadow : function() {
		this.m_iShadow = 1;
		return this;
	},
	addCaption : function(p_sText, p_sFontFile, p_iFontSize) {
		this.m_sCaption 	= p_sText;
		this.m_sFontFile 	= p_sFontFile;
		this.m_iFontSize	= p_iFontSize;
		return this;
	},
	addChuckNorris : function() {
		this.m_iChuck = 1;
		return this;
	}
}	
