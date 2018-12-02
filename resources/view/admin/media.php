<?php vjoin('admin-layouts/header'); ?>
<? $count_media = count($media_list); ?>
<div class="container">
	<div class="page" id="cats">
		<div class="jumbotron">
		  <h1 class="display-4">Загруженные изображения</h1>
			<hr class="my-4">
			<div class="row">
				<? for($i=0; $i<4; $i++): ?>
					<div class="col-3">
						<?php for($j=$i; $j<$count_media; $j += 4): ?>
							<? $media = $media_list[$j]; ?>
							<div class="card media-item">
							  <img class="card-img-top" src="<?= $media['src'] ?>" data-toggle="modal" data-target="#img-view" data-img-view-id="<?= $media['id'] ?>">
							  <div class="card-body">
							    <button type="button" class="btn btn-primary card-link" data-toggle="modal" data-target="#img-view" data-img-view-id="<?= $media['id'] ?>">Просмотр</button>
							    <a href="<?= linkTo('MediaController@remove', ['media_id' => $media['id']]) ?>" class="card-link danger-link">Удалить</a>
							  </div>
							</div>
						<?php endfor ?>
					</div>
				<? endfor; ?>
			</div>
			<br>
			<hr class="my-4">
			<br>
			<nav>
			  <ul class="pagination">
			  	<?php if ($pagination[0]['prev']): ?>
			  		<li class="page-item">
				      <a class="page-link" href="<?= $pagination[0]['prev'] ?>" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				        <span class="sr-only">Previous</span>
				      </a>
				    </li>
			  	<?php endif ?>
			    <?php foreach ($pagination[1] as $i => $item): ?>
			    	<li class="page-item <?= $item['current'] ? 'active' : '' ?>">
			    		<? if(!$item['current']): ?>
			    			<a class="page-link" href="<?= $item['link'] ?>"><?= $item['num'] ?></a>
		    			<? else: ?>	
		    				<span class="page-link"><?= $item['num'] ?><span class="sr-only">(current)</span></span>
		    			<? endif; ?>
			    	</li>
			    <?php endforeach ?>
			    <?php if ($pagination[0]['next']): ?>
			    	<li class="page-item">
				      <a class="page-link" href="<?= $pagination[0]['next'] ?>" aria-label="Next">
				        <span aria-hidden="true">&raquo;</span>
				        <span class="sr-only">Next</span>
				      </a>
				    </li>
			    <?php endif ?>
			  </ul>
			</nav>
		</div>
	</div>
</div>

<div class="modal fade" id="img-view" tabindex="-1" role="dialog" aria-labelledby="img-view-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="img-view-label">Просмотр изображения</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" class="img-view-big-img" alt="LOADING">
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('[data-img-view-id]').on('click', function(){
			let bigimg = $('#img-view .img-view-big-img');
			$(bigimg).attr('src', '');
			let url = '/admin/media/img-preview/' + $(this).attr('data-img-view-id');
			$.get(url, function(res){
				$(bigimg).attr('src', res);
			});
		});
	});
</script>

<?php vjoin('admin-layouts/footer'); ?>