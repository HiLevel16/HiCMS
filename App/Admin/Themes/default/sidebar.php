<nav id="sidebar">
<div class="custom-menu">
    <button type="button" id="sidebarCollapse" class="btn btn-primary">
        <i class="list icon"></i>
    </button>
</div>
<ul class="list-unstyled components mb-5">
<?php foreach ($menus as $menu) {
    echo '<li class="';
    if ($currentPage == $menu->getName())
    echo 'active';
    else 
    echo 'unactive';
    echo '"><a href="'.$menu->getLink().'" class="sidebar"><span class="'.$menu->getIcon().'"></span>'.$menu->getName().'</a></li>';
}
?>
</ul>

</nav>