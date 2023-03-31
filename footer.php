<?php
/**
* The template for displaying the footer
**/

$acf_general_blocks = get_field('acf_general_blocks', 'option');
echo ama_general_blocks( $acf_general_blocks );
?>
</main>
<?php do_action('ama_theme_footer');?>

</div><!-- #wrapper -->
<?php wp_footer();?>

</body>
</html>