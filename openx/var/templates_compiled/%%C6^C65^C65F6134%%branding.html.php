<?php /* Smarty version 2.6.18, created on 2014-11-15 14:39:48
         compiled from layout/branding.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'layout/branding.html', 28, false),)), $this); ?>
<?php if ($this->_tpl_vars['applicationName'] && $this->_tpl_vars['logoFilePath']): ?>
    <div id="oaHeaderBranding" class="brandingCustom"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/<?php echo ((is_array($_tmp=$this->_tpl_vars['logoFilePath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['applicationName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></div>
<?php elseif ($this->_tpl_vars['applicationName']): ?>
    <div id="oaHeaderBranding" class="brandingName"><?php echo ((is_array($_tmp=$this->_tpl_vars['applicationName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
<?php else: ?>
    <div id="oaHeaderBranding" class="brandingAdServer"><?php echo $this->_tpl_vars['productName']; ?>
</div>
<?php endif; ?>