
    <footer id="f0" class="bt">
      <nav class="w0">
      	<ul id="fl" class="ful">
          <li><a title="About edspire" href="/about/">About us</a></li>
          <li><a title="Reader our blog to find out what's new" href="/blog/">Blog</a></li>
          <li><a title="How to contact edspire by post or email" href="/contact/">Contact</a></li>
          <li><a title="Help topics and FAQs" href="/help/">Help</a></li>
          <li><a title="Terms and conditions governing your use of edspire" href="/terms-of-use/">Terms of use</a></li>
          <li><a title="See how edspire respects your privacy" href="/privacy-policy/">Privacy policy</a></li>
          <?php if ( is_user_logged_in() ): ?> 
          <li><a title="Log out of your account" href="<?php echo wp_logout_url() ?>">Log out</a></li>
          <?php endif;?>
        </ul>
      
	  </nav>
    </footer>
    
    <?php if (current_user_can( 'manage_options' )): ?>
    <script async src="<?php echo get_themeroot(); ?>/js/admin.js"></script>
    <a href="/superuser/<?php echo the_ID(); ?>/" style="position: fixed; top: 0; right: 260px; z-index: 100; padding: 1.4em 2em; background-color: #000; color: #fff;">Edit</a>
    <?php endif; ?>
    
  </body>
</html>