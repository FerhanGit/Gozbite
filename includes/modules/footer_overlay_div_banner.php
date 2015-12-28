<?php

$footer_overlay_div = "";

$footer_overlay_div .='<div></div>
	<div id="footer_overlay_div_Content" style="display: none;" >Моля, изчакайте...</div>
	<div id="footer_overlay_div">
	<div style="z-index:2000">
		<a href="javascript:void(0);" onclick=" if ($(\'footer_overlay_div_Content\').visible()) { new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\');} update_footer_overlay_div_Content(\'footer_overlay_banners/overlay_promo.html\'); new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\'); "><img class="footer_overlay_banner" height="15" onmouseover="this.className=\'footer_overlay_banner_clear\'" onmouseout="this.className=\'footer_overlay_banner\'" src="images/footer_overlay_promo.png" /></a>
		<a href="javascript:void(0);" onclick=" if ($(\'footer_overlay_div_Content\').visible()) { new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\');} update_footer_overlay_div_Content(\'footer_overlay_banners/avtori.html\'); new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\'); "><img class="footer_overlay_banner" height="15"  onmouseover="this.className=\'footer_overlay_banner_clear\'" onmouseout="this.className=\'footer_overlay_banner\'"src="images/footer_overlay_banners/avtori.png" /></a>
		<a href="javascript:void(0);" onclick=" if ($(\'footer_overlay_div_Content\').visible()) { new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\');} update_footer_overlay_div_Content(\'footer_overlay_banners/shop2bg.html\'); new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\'); "><img class="footer_overlay_banner" height="15"  onmouseover="this.className=\'footer_overlay_banner_clear\'" onmouseout="this.className=\'footer_overlay_banner\'"src="images/footer_overlay_banners/shop2bg.png" /></a>
		<a href="javascript:void(0);" onclick=" if ($(\'footer_overlay_div_Content\').visible()) { new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\');} update_footer_overlay_div_Content(\'footer_overlay_banners/overlay_promo.html\'); new Effect.toggle($(\'footer_overlay_div_Content\'),\'Blind\'); "><img class="footer_overlay_banner" height="15"  onmouseover="this.className=\'footer_overlay_banner_clear\'" onmouseout="this.className=\'footer_overlay_banner\'"src="images/footer_overlay_promo.png" /></a>
	</div>
	</div>
</div>';

return $footer_overlay_div;
