<?php
/* Smarty version 4.3.0, created on 2023-03-28 20:26:39
  from 'C:\xampp\htdocs\DWES04\templates\listado.tpl.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6423315f3f0024_75103746',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46d1cce1b1e5cd342efaa8e858506df16af9af94' => 
    array (
      0 => 'C:\\xampp\\htdocs\\DWES04\\templates\\listado.tpl.html',
      1 => 1680027995,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6423315f3f0024_75103746 (Smarty_Internal_Template $_smarty_tpl) {
?><table border="1" style=" margin: 0 auto">
    <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Operaciones</th>
    </tr>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['productos']->value, 'producto');
$_smarty_tpl->tpl_vars['producto']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['producto']->value) {
$_smarty_tpl->tpl_vars['producto']->do_else = false;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['producto']->value->getId();?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['producto']->value->getCod();?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['producto']->value->getDesc();?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['producto']->value->getPrecio();?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['producto']->value->getStock();?>
</td>
        <td>
            <form method="post" action="action">
                <button type="submit">Editar</button>
            </form>
            <form method="post" action="/DWES04/borrarproducto">  <!-- /DWES04/borrarproducto/<?php echo $_smarty_tpl->tpl_vars['producto']->value->getId();?>
-->
                <button type="submit">Borrar</button>
            </form>
        </td>
        
    </tr>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <tr>
        <td colspan="6" style="text-align:center;">
            <form method="post" action="/DWES04/nuevoproducto"> 
                  <button type="submit">Nuevo producto</button>
            </form>
        </td>
    </tr>
</table><?php }
}
