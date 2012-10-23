<h2 style="position: relative;"><?=$this->fuel_blog->settings('title')?><?=(isset($category) ? ' : ' . ucwords($category) : '')?> 
<a class="rss_link" href="<?=current_url() . '/feed'?>">Subscribe</a></h2>

<?=$this->fuel_blog->block('posts')?>
