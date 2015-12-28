//--------------------------------------------------------------------------------------------------
// All material contained within this and associated downloaded pages is the property of 4thorder(TM)
// Copyright © 2005.  All rights reserved.
//
// Author: Michael Falatine || Authors email: 4thorder@4thorder.us
//
// USAGE: You may use this script for commercial or personal use, however, the copyright is retained-
// by 4thorder (TM).
//
// For other free Scripts visit: http://www.4thorder.us/Scripts/
//---------------------------------------------------------------------------------------------------

// ||||||||||||||||
// | Basic Set-up  |
// ||||||||||||||||

// DIMENSION SETTINGS (pixels) [Value MUST NOT be in qoutes]:
   // Set position from LEFT of page
   var PagePositionLEFT = 0;
   // Set position from TOP of page
   var PagePositionTOP  = 0;

// BRANCH CONTROL SETTINGS [Value MUST be in quotes]:
   // Enable single branch opening ONLY
   // Options: ['yes'=one branch at a time, ''=all branches will open]
   // Note: ALL Values other than 'yes' allows user to open more than one branch at a time
   var oneBranch = 'yes';
      // If selecting this option the "Expand-Collapse ALL" option WILL NOT be available

// IMAGE SETTINGS [Value MUST be in quotes]:
   // Include "Expand-Collapse ALL" option
   // Options: ['yes'=Shows option, ''=Hides option]
   // Note: ALL Values other than 'yes' HIDES option
   var showECOption = 'no';
      // If oneBranch value is set to 'yes' (above) the "Expand-Collapse ALL" option WILL NOT be available

// TRANSPARENCY SETTINGS (%) [Value MUST NOT be in qoutes]:
   var TValue = 100;
      // 100=100% visible, 0=invisible [MUST BE  a number between 0 and 100]
      // Can be decimal (example: 70.5) or integer (example: 71)


// |||||||||||||||||||||||
// | Define Images Here  |
// |||||||||||||||||||||||
// All values MUST be in quotes
// All images MUST be located in the folder "MDMEImages"
// "MDMEImages" folder MUST be located in SAME directory as MultiLevelDHTMLMenuExpanderV11.js file
// Note: Some images have been provided.  You may use provided, your own, or none.
// Sample images provided can be viewed in the "StartHere.htm" file

// If you DO NOT want images attached then leave these values BLANK
// HOWEVER, if you leave either 'imageEXPANDALL' or 'imageCOLLAPSEALL' blank make sure
// 'showECOption' is also blank

// SET [EXPAND] IMAGE FILE NAME:
   // Filenames of samples provided:
   // threedPLUS.gif | folderPLUS.gif | SimplePLUS.gif | thickBorderedPLUS.gif | thinBorderedPLUS.gif
      var imagePLUS  = 'folder_add.png';

// SET [COLLAPSE] IMAGE FILE NAME:
   // Filenames of samples provided:
   // threedMINUS.gif | folderMINUS.gif | SimpleMINUS.gif | thickBorderedMINUS.gif | thinBorderedMINUS.gif
      var imageMINUS = 'folder_delete.png';
      // IF left blank AND imagePLUS is NOT blank THEN [EXPAND] IMAGE will be present at all times
      // This scenario can be used for example if you DONT want toggling +/- images

// SET [EXPAND ALL] IMAGE FILE NAME:
   // Filenames of samples provided:
   // twodEXPANDALL.gif | threedEXPANDALL.gif | folderEXPANDALL.gif
      var imageEXPANDALL = 'folderEXPANDALL.gif';
      // IF left blank AND showECOption='yes' (above) THEN text "Expand ALL" will be visible

// SET [COLLAPSE ALL] IMAGE FILE NAME:
   // Filenames of samples provided:
   // twodCOLLAPSEALL.gif | threedCOLLAPSEALL.gif | folderCOLLAPSEALL.gif
      var imageCOLLAPSEALL = 'folderCOLLAPSEALL.gif';
      // IF left blank AND showECOption='yes' (above) THEN text "Collapse ALL" will be visible



