<?php /* Smarty version 2.6.18, created on 2014-11-15 14:41:21
         compiled from options/break.html */ ?>
<?php if (! isset ( $this->_tpl_vars['aItem']['size'] ) || $this->_tpl_vars['aItem']['size'] == '' || $this->_tpl_vars['aItem']['size'] == 'small'): ?>
<tr>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'></td>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break-l.gif' height='1' width='250' vspace='10'></td>
    <td>&nbsp;</td>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'></td>
</tr>
<?php elseif ($this->_tpl_vars['aItem']['size'] == 'large'): ?>
<tr>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='3'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break-l.gif' height='1' width='100%' vspace='10'></td>
</tr>
<?php elseif ($this->_tpl_vars['aItem']['size'] == 'full'): ?>
<tr>
    <td colspan='4'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break.gif' height='1' width='100%' vspace='16'></td>
</tr>
<?php elseif ($this->_tpl_vars['aItem']['size'] == 'empty'): ?>
<tr>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'></td>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='250' vspace='10'></td>
    <td>&nbsp;</td>
    <td><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'></td>
</tr>
<?php endif; ?>