//--------------------------------------------------------------------------------------------------
// All material contained within this document and associated downloaded pages
// is the property of 4thorder(TM) unless otherwise noted
// Copyright © 2005.  All rights reserved.
//
// Author: Michael Falatine || Authors email: 4thorder@4thorder.us
//
// USAGE: You may use this script for commercial or personal use, however, the copyright is retained-
// by 4thorder (TM).
//
// For other free Scripts visit: http://www.4thorder.us/Scripts/
//---------------------------------------------------------------------------------------------------

//-----------------begin insertAdjacent code-----------------------------------------------------
// This portion written by Thor Larholm thor@jscript.dk
// Allows for insertAdjacentHTML(), insertAdjacentText() and insertAdjacentElement()
// functionality in Netscape / Mozilla /Opera
if(typeof HTMLElement != "undefined" && !HTMLElement.prototype.insertAdjacentElement) {
   HTMLElement.prototype.insertAdjacentElement = function(where, parsedNode) {
      switch (where){
         case 'beforeBegin':
             this.parentNode.insertBefore(parsedNode,this)
             break;
         case 'afterBegin':
             this.insertBefore(parsedNode,this.firstChild);
             break;
         case 'beforeEnd':
             this.appendChild(parsedNode);
             break;
         case 'afterEnd':
             if (this.nextSibling) this.parentNode.insertBefore(parsedNode,this.nextSibling);
             else this.parentNode.appendChild(parsedNode);
         break;
      }
   }

   HTMLElement.prototype.insertAdjacentHTML = function(where,htmlStr) {
      var r = this.ownerDocument.createRange();
      r.setStartBefore(this);
      var parsedHTML = r.createContextualFragment(htmlStr);
      this.insertAdjacentElement(where,parsedHTML)
   }


   HTMLElement.prototype.insertAdjacentText = function(where,txtStr) {
      var parsedText = document.createTextNode(txtStr)
      this.insertAdjacentElement(where,parsedText)
   }
}
//----------------------end insertAdjacent code-------------------------------------------------------

// :::::::::::::::::::::::::
// :::: Global Variables :::
// :::::::::::::::::::::::::
var firstLoad = 0;
var GlobalECState = 0;
var svdCkStr = "";
// :::::::::::::::::::::::::
// :::: Global Functions :::
// :::::::::::::::::::::::::
//window.onload = InitializePage;

function InitializePage() {
   defineLayout();
   prepareListStyles();
   setLEVELs();
   Icons();
   loadEC();
   attachEventhandlers();
}

function defineLayout() {
   // Set Page position
   //document.getElementById("MDME").style.position = "relative";
   document.getElementById('MDME').style.marginLeft = PagePositionLEFT+"px";
   document.getElementById('MDME').style.marginTop = PagePositionTOP+"px";
   //document.getElementById('MDME').style.zIndex = 50;
}

function setLEVELs() {
   ULCollection = document.getElementById("MDME").getElementsByTagName("ul");
   ULCollection.item(0).setAttribute("level", 1);

   // Initally set all LI to level 1
   LICollection = document.getElementById("MDME").getElementsByTagName("li");
   for (a = 0; a < LICollection.length; a++) {
      LICollection.item(a).setAttribute("level", 1);
   }

   // Set all non-level 1 LI to respective levels
   if (ULCollection != null) {
     for (u = 0; u < ULCollection.length; u++) {
        var ULChildrenCollection = ULCollection.item(u).getElementsByTagName("ul");
        for (l = 0; l < ULChildrenCollection.length; l++) {
           var previousLevel = parseInt(ULCollection.item(u).getAttribute("level"));
           ULChildrenCollection.item(l).setAttribute("level", previousLevel+1);
           var LIChildrenCollection=ULChildrenCollection.item(l).getElementsByTagName("li");
           for (m = 0; m < LIChildrenCollection.length; m++) {
              LIChildrenCollection.item(m).setAttribute("level", previousLevel+1);
           }
        }
      }
   }
}

function prepareListStyles() {
   ULCollection = document.getElementById("MDME").getElementsByTagName("ul");

   if (ULCollection != null) {
      for (u = 0; u < ULCollection.length; u++) {
         ULCollection.item(u).style.listStyleType = "none";
         ULCollection.item(u).setAttribute("id", "ULID"+u);
      }
   }
}

function attachEventhandlers() {
   // Attach event handlers to all images within container
   LICollection = document.getElementById("MDME").getElementsByTagName("li");

   if (LICollection != null) {
      for (l = 0; l < LICollection.length; l++) {
         LICollection.item(l).onmouseup = onMouseUpHandler;
      }
   }

   // Set Transparency level
   if(navigator.appName == 'Microsoft Internet Explorer') {
      document.getElementById('MDME').style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity="+TValue+")";
   } else {
      document.getElementById('MDME').style.MozOpacity = 1;
      TValue = parseFloat(TValue/100-.001); // .001 is fix for moz opacity/image bug
      document.getElementById('MDME').style.MozOpacity = TValue;
   }
}

// Expand or Collapse "ALL" routine
function ECALL(o) {
   //strip all images
   LICollection=document.getElementById("MDME").getElementsByTagName("li");

   if (LICollection != null) {
      for (d = 0; d < LICollection; d++) {
         LICollection.item(i).style.listStyleImage = "none";
      }
   }

   firstLoad = 0;
   GlobalECState = o;
   Icons();

   if(showECOption == "yes" && oneBranch != "yes") {
      if(GlobalECState == 0) {
         document.getElementById("expandAllMenuItem").style.display = "inline";
         document.getElementById("collapseAllMenuItem").style.display = "none";
      } else {
         document.getElementById("expandAllMenuItem").style.display = "none";
         document.getElementById("collapseAllMenuItem").style.display = "inline";
      }
   }
}

function Icons(tarObj) {

   LICollection = document.getElementById("MDME").getElementsByTagName("li");

   // Loop through and insert icons at LI elements with children
   if (LICollection != null) {
      for (i = 0; i < LICollection.length; i++) {
         // Collection used to determine if list item has UL children
         ULChildrenCol = LICollection.item(i).getElementsByTagName("ul");

         // If children then put a "-" or "+" on folder depending on ECState or GlobalECState
         //Set ECState attributes
         if(ULChildrenCol.length > 0) {
            // Yes HAS Children
            // Grab first UL underneath LI
            FirstULWithinLI_ELEMENT = LICollection.item(i).getElementsByTagName("ul");
            if(firstLoad == 0) {
               // Yes: FIRST LOAD OF PAGE -- insert image
               if(GlobalECState == 0) {
                  // Global ECState is COLLAPSED (+)	(0)
                  // set ECState, attach image to LI, Hide UL children
                  LICollection.item(i).setAttribute("ECState", 0);
                  if(imagePLUS != '') {
                     LICollection.item(i).style.listStyleImage = "url(images/" + imagePLUS + ")";
                     LICollection.item(i).style.listStylePosition = "inside";
                  }

                  //LICollection.item(i).style.cursor = "pointer";
                  FirstULWithinLI_ELEMENT.item(0).style.display = "none";
               } else {
                  // Global ECState is EXPANDED (-) (1)
                  // set ECState, attach image to LI, Show UL children
                  LICollection.item(i).setAttribute("ECState", 1);
                  if(imageMINUS != '') {
                     LICollection.item(i).style.listStyleImage = "url(images/" + imageMINUS + ")";
                     LICollection.item(i).style.listStylePosition = "inside";
                  }

                  //LICollection.item(i).style.cursor = "pointer";
                  FirstULWithinLI_ELEMENT.item(0).style.display = "block";
               }
            } else {
               // No: FIRST LOAD OF PAGE - change image
               //	Grab ECState of image and expand or collapse branch
               State = LICollection.item(i).getAttribute("ECState");
               if(State == 0) {
                  // ECState is COLLAPSED (+) (0)
                  // Change Image and set cursor style
                  if(imagePLUS != '') {
                     LICollection.item(i).style.listStyleImage = "url(images/" + imagePLUS + ")";
                     LICollection.item(i).style.listStylePosition = "inside";
                  }

                  // Hide UL
                  FirstULWithinLI_ELEMENT.item(0).style.display = "none";
               } else {
                  // ECState is EXPANDED (-) (1)
                  // If option activated: Rountine to close all branches on same level as target but NOT target
                  if(oneBranch == "yes" && tarObj != null) {
                     targetLevel = tarObj.getAttribute("level");
                     tarObjParentLICol = tarObj.parentNode.getElementsByTagName("li");
                     for (tar = 0; tar < tarObjParentLICol.length; tar++) {
                        ItemLevel = tarObjParentLICol.item(tar).getAttribute("level");
                        if(targetLevel == ItemLevel) {
                           tarObjParentLIULCol = tarObjParentLICol.item(tar).getElementsByTagName("ul");
                           if(tarObjParentLIULCol.length != 0 && tarObj != tarObjParentLICol.item(tar)) {
                              tarObjParentLIULCol.item(0).style.display = "none";

                              if(imagePLUS != '') {
                                 tarObjParentLICol.item(tar).style.listStyleImage = "url(images/" + imagePLUS + ")";
                                 tarObjParentLICol.item(tar).style.listStylePosition = "inside";
                                 tarObjParentLICol.item(tar).setAttribute("ECState",0);
                              }
                           }
                        }
                     }
                  }

                  // Change Image and set cursor style
                  if(imageMINUS != '') {
                     LICollection.item(i).style.listStyleImage = "url(images/" + imageMINUS + ")";
                     LICollection.item(i).style.listStylePosition = "inside";
                  }

                  // Show UL
                  FirstULWithinLI_ELEMENT.item(0).style.display = "block";
               }
            }
         } else {
            LICollection.item(i).style.listStyleImage = "none";
         }

         if(tarObj != null) {
            currState = LICollection.item(i).getAttribute("ECState");
            if(currState == 1) {
               if(svdCkStr.length > 0)
                  svdCkStr += "|" + LICollection.item(i).id
               else
                  svdCkStr = LICollection.item(i).id;
            }
         }
      }
   }

   if(firstLoad == 0) {
      firstLoad = 1;
   }

   if(showECOption == "yes" && oneBranch != "yes") {
      document.getElementById('expandAllMenuItem').style.cursor = "pointer";
      document.getElementById('collapseAllMenuItem').style.cursor = "pointer";
   }

   if(tarObj != null) {
      eraseCookie('LctnSvd');
      createCookie('LctnSvd', svdCkStr, 1);
   } else {
      //eraseCookie('LctnSvd');
   }
   svdCkStr = "";
}

// ::::::::::::::::::::::::
// :::: Event Handlers ::
// ::::::::::::::::::::::::

function onMouseUpHandler(e) {
   // Browser compatibility code
   var tarObj;
   if (!e)
      var e = window.event;
   if (e.target)
      tarObj = e.target;
   else if (e.srcElement)
      tarObj = e.srcElement;

   if (tarObj.nodeType == 3) // defeat Safari bug
      tarObj= tarObj.parentNode;

   tarObj = findTH(tarObj);

   // Toggle ECState
   State = tarObj.getAttribute("ECState");
   if(State == 0) {
      tarObj.setAttribute("ECState", 1);
   } else {
      tarObj.setAttribute("ECState", 0);
   }

   Icons(tarObj);
   e.cancelBubble = true;
}

function findTH(t) {
   if (t.tagName == "LI") {
      return t;
   } else if (t.tagName == "UL") {
      return null;
   } else {
      return findTH(t.parentNode);
   }
}

function loadEC() {
   cc = readCookie('LctnSvd');
   //document.getElementById("lID175").click();
   /*if(cc) {
      ccArr = cc.split("|");

      if(ccArr.length > 0) {
         for(var i = 0; i < ccArr.length; i++) {
            currElm = document.getElementById(ccArr[i]);
            currElm.click();
         }
      }
   }*/
}

//Cookies
function createCookie(name, value, days) {
   if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      var expires = "; expires=" + date.toGMTString();
   } else
      var expires = "";
   document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
   var nameEQ = name + "=";
   var ca = document.cookie.split(';');

   for(var i = 0; i < ca.length; i++) {
      var c = ca[i];

      while (c.charAt(0) == ' ')
         c = c.substring(1, c.length);

      if (c.indexOf(nameEQ) == 0)
         return c.substring(nameEQ.length, c.length);
   }
   return null;
}

function eraseCookie(name) {
   createCookie(name, "", -1);
}
// End Coockies