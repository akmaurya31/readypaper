
        <div class="footer">
            <div class="copyright">               
                <p>Copyright © Designed &amp; Developed by <a href="javascript:;" target="_blank">Readypaper</a> <?= date('Y')?></p>
            </div>
        </div>



	</div>
   
    <!-- Required vendors -->
    <script src="<?= base_url()?>assets/vendor/global/global.min.js"></script>
	<script src="<?= base_url()?>assets/vendor/chart.js/Chart.bundle.min.js"></script>
	<script src="<?= base_url()?>assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	
	<!-- PaikSoft Technologies -->
	
<script src="<?= base_url()?>assets/vendor/apexchart/apexchart.js"></script>
<script src="<?= base_url()?>assets/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="<?= base_url()?>assets/js/dashboard/dashboard-1.js"></script>	
	
	 <script src="<?= base_url()?>assets/js/common.js"></script>

	
	<!-- Chart piety plugin files -->
    <script src="<?= base_url()?>assets/vendor/peity/jquery.peity.min.js"></script>
	
	   <!-- Datatable -->
    <script src="<?= base_url()?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url()?>assets/js/plugins-init/datatables.init.js"></script>
	
	
	
	<script src="<?= base_url()?>assets/vendor/owl-carousel/owl.carousel.js"></script>
	
    <script src="<?= base_url()?>assets/js/custom.min.js"></script>
	<script src="<?= base_url()?>assets/js/dlabnav-init.js"></script>
	<script src="<?= base_url()?>assets/js/dashboard/statistics-page.js"></script>
	<script>
    function teacher_school(id){
      alert();
    }

    function teacher_payment(id){
      alert();
    }

    
    </script>
    
	<script>
		function JobickCarousel()
			{

				/*  testimonial one function by = owl.carousel.js */
				jQuery('.front-view-slider').owlCarousel({
					loop:false,
					margin:30,
					nav:true,
					autoplaySpeed: 3000,
					navSpeed: 3000,
					autoWidth:true,
					paginationSpeed: 3000,
					slideSpeed: 3000,
					smartSpeed: 3000,
					autoplay: false,
					animateOut: 'fadeOut',
					dots:true,
					navText: ['', ''],
					responsive:{
						0:{
							items:1
						},
						
						480:{
							items:1
						},			
						
						767:{
							items:3
						},
						1750:{
							items:3
						}
					}
				})
			}

			jQuery(window).on('load',function(){
				setTimeout(function(){
					JobickCarousel();
				}, 1000); 
			});
	</script>
<script src="<?php echo base_url(); ?>assets/common/admin/common.js"></script>

<script src="https://cdn.ckeditor.com/4.14.0/standard-all/ckeditor.js"></script>


  <script>
    (function() {
      var mathElements = [
        'math',
        'maction',
        'maligngroup',
        'malignmark',
        'menclose',
        'merror',
        'mfenced',
        'mfrac',
        'mglyph',
        'mi',
        'mlabeledtr',
        'mlongdiv',
        'mmultiscripts',
        'mn',
        'mo',
        'mover',
        'mpadded',
        'mphantom',
        'mroot',
        'mrow',
        'ms',
        'mscarries',
        'mscarry',
        'msgroup',
        'msline',
        'mspace',
        'msqrt',
        'msrow',
        'mstack',
        'mstyle',
        'msub',
        'msup',
        'msubsup',
        'mtable',
        'mtd',
        'mtext',
        'mtr',
        'munder',
        'munderover',
        'semantics',
        'annotation',
        'annotation-xml'
      ];

      CKEDITOR.plugins.addExternal('ckeditor_wiris', 'https://ckeditor.com/docs/ckeditor4/4.14.0/examples/assets/plugins/ckeditor_wiris/', 'plugin.js');

      CKEDITOR.replace('editor1', {
        extraPlugins: 'ckeditor_wiris',
        // For now, MathType is incompatible with CKEditor file upload plugins.
        removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
        height: 320,
        // Update the ACF configuration with MathML syntax.
        extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
      });

	  
	  CKEDITOR.replace('editor2', {
        extraPlugins: 'ckeditor_wiris',
        // For now, MathType is incompatible with CKEditor file upload plugins.
        removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
        height: 320,
        // Update the ACF configuration with MathML syntax.
        extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
      });

	  CKEDITOR.replace('editor3', {
        extraPlugins: 'ckeditor_wiris',
        // For now, MathType is incompatible with CKEditor file upload plugins.
        removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
        height: 320,
        // Update the ACF configuration with MathML syntax.
        extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
      });

	  CKEDITOR.replace('editor4', {
        extraPlugins: 'ckeditor_wiris',
        // For now, MathType is incompatible with CKEditor file upload plugins.
        removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
        height: 320,
        // Update the ACF configuration with MathML syntax.
        extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
      });

	  CKEDITOR.replace('editor5', {
        extraPlugins: 'ckeditor_wiris',
        // For now, MathType is incompatible with CKEditor file upload plugins.
        removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
        height: 320,
        // Update the ACF configuration with MathML syntax.
        extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
      });

	  CKEDITOR.replace('editor6', {
        extraPlugins: 'ckeditor_wiris',
        // For now, MathType is incompatible with CKEditor file upload plugins.
        removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
        height: 320,
        // Update the ACF configuration with MathML syntax.
        extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
      });

    }());
  </script>



	<!-- CK Editor -->
<!--<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

<script type="text/javascript">
$(function () {
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
CKEDITOR.replace('editor1');
CKEDITOR.replace('editor2');
CKEDITOR.replace('editor3');
CKEDITOR.replace('editor4');
CKEDITOR.replace('editor5');
CKEDITOR.replace('editor6');
CKEDITOR.replace('editor7');
CKEDITOR.replace('editor8');
//bootstrap WYSIHTML5 - text editor
$(".textarea").wysihtml5();
});
</script>-->



</body>
</html>