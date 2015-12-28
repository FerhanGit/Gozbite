/**
* Rotator extension of the controller.
*
* @author	Jeroen Wijering
* @version	1.2
**/


import com.jeroenwijering.players.*;
import com.jeroenwijering.utils.*;


class com.jeroenwijering.players.RotatorController extends AbstractController{


	/** Which one of the models to send the changes to **/
	private var currentModel:Number;


	/** Constructor, inherited from super **/
	function RotatorController(car:Object,far:Array) { super(car,far); };


	/** Complete the build of the MCV cycle and start flow of events. **/
	public function startMCV(mar:Array) {
		registeredModels = mar;
		sendChange("item",currentItem);
		if(configArray["autostart"] == "false" && 
			fileArray[currentItem]["category"] != "commercial") {
			sendChange("start",0);
			sendChange("pause",0);
			isPlaying = false;
		} else { 
			sendChange("start",0);
			isPlaying = true;
		}
	};


	/** Switch active model and send changes. **/
	private function sendChange(typ:String,prm:Number):Void {
		if(typ == "item") { 
			currentModel == 0 ? currentModel = 1: currentModel = 0;
		}
		registeredModels[currentModel].getChange(typ,prm);
	};


}