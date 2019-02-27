<section class="reviews">
		<? $count_reviews = count($reviews) ?>
		<h2 class="block-title"><?= $profile['name'] ?> отзывы <small class="txt-grey-light">(<?= $count_reviews ?> шт)</small></h2>
		<div class="row">
			<? if(count($reviews)): $i = 0; ?>
				<? for($n=0; $n<2; $n++): ?>
					<div class="col-12 col-lg-6 col-xl-6">
						<? for($i=$n; $i<$count_reviews; $i+=2): ?>
							<div class="block review-item" id="review-<?= $reviews[$i]['id'] ?>">
								<div class="row">
									<div class="col-2 thumb">
										<? if($reviews[$i]['rating'] == 1): ?>
											<i class="mdi mdi-thumb-up font-color-green mdi-big"></i><? elseif($reviews[$i]['rating'] == -1): ?>
											<i class="mdi mdi-thumb-down font-color-red mdi-big"></i><? else: ?>
											<i class="mdi mdi-thumbs-up-down font-color-grey mdi-big"></i>
										<? endif; ?>
									</div>
									<div class="col-10">
										<div class="review-head">
											<span class="txt-grey-dark"><?= $reviews[$i]['username'] ?></span> <span class="txt-grey-light">о маге</span> <a href="#" class="std-a"><?= $profile['name'] ?></a>
										</div>
										<div class="review-body txt-grey-dark">
											<? if($reviews[$i]['image']): ?>
												<img src="<?= $reviews[$i]['image'] ?>" style="width: 100%; margin-bottom: 10px;" alt="image">
											<? endif; ?>
											<?= $reviews[$i]['message'] ?> 
										</div>
										<div class="review-foot">
											<span class="txt-grey-light timestamp">Оставлен <?= $reviews[$i]['timestamp'] ?></span> <a href="#" class="std-a">Коментарии <span class="txt-grey">(<?= count($reviews[$i]['comments']) ?>)</span></a>
											<? if(is_admin()): ?>
												---- <a href="<?= linkTo('ReviewController@review_edit', ['id' => $reviews[$i]['id']]); ?>" class="std-a danger-link">Редактировать</a>
											<? endif; ?>
										</div>
									</div>
									<div class="col-12 comments">
										<div class="col-12 bottom-border"></div>
										<button class="close-comments"><i class="m-icon close"></i></button>
										<h3 class="block-title">Комментарии к отзыву <small>(<?= count($reviews[$i]['comments']) ?> шт)</small></h3>
										
										<?php foreach ($reviews[$i]['comments'] as $j => $comment): ?>
										
											<div class="comment-item">
												<div class="row">
													<div class="col-2 avatar-container">
														<div class="avatar txt-grey" data-fl-content="<?= $comment['name'] ?>">А</div>
													</div>
													<div class="col-10">
														<div class="head txt-grey-dark"><?= $comment['name'] ?> <span class="txt-grey">сказал(а):</span></div>
														<div class="body"><?= $comment['message'] ?></div>
														<div class="foot txt-grey-light">Оставлен <?= $comment['timestamp'] ?></div>
													</div>
												</div>
											</div>

										<?php endforeach ?>	

										<div class="comments-paginator">
											<span class="txt-grey cp-counter">3 из 5</span>
											<button class="std-btn prev-comments-page"></button>
											<button class="std-btn next-comments-page"></button>
										</div>

										<div class="notification">Ваш коментарий был отправлен на модерацию</div>

										<div class="new-comment" data-review-id="<?= $reviews[$i]['id'] ?>">
											<div class="input">
												<i class="mdi mdi-account input-icon"></i>
												<input type="text" name="name" placeholder="Ваше имя" value="<?= \Kernel\Sess::get('username') ?>">
											</div>

											<div class="input textarea">
												<i class="mdi mdi-message-text input-icon"></i>
												<textarea type="text" name="message" placeholder="Ваш комментарий"></textarea>
											</div><br>

											<button class="std-btn icon-fix send-btn disable">Отправить <i class="mdi mdi-arrow-right mdi-fix"></i></button>
										</div>
									</div>

								</div>
							</div>
						<? endfor ?>
					</div>
				<? endfor; ?>
			<? endif; ?>
		</div>
	</section>