<div class="row">
	<?php echo form_open_multipart(current_url()); ?>
	<div class="col-md-9">
		<div class="form-group">
			<div class="col-md-10 col-md-offset-2">
				<?php echo $this->session->flashdata('alert'); ?>
			</div>
		</div>
		<div class="form-group">
			<label>Judul</label>
			<input type="text" name="judul" class="form-control" value="<?php echo (!set_value('judul')) ? $post->post_title : set_value('judul') ?>" placeholder="Masukkan Judul Disini ..." autofocus>
			<p class="help-block"><?php echo form_error('judul', '<small class="text-red">', '</small>'); ?></p>
		</div>
		<div class="form-group">
			<label>Slug</label>
			<input type="text" name="slug" class="form-control" value="<?php echo (!set_value('slug')) ? $post->post_slug : set_value('slug') ?>">
			<p class="help-block"><?php echo form_error('slug', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>"Slug" ialah versi ramah-URL dari nama. Biasanya seluruhnya merupakan huruf kecil dan hanya mengandung huruf, angka, dan tanda strip.</i></small></p>
		</div>
		<div class="form-group">
			<textarea name="content" rows="20" class="tinymce"><?php echo (!set_value('content')) ? $post->post_content : set_value('content') ?></textarea>
			<p class="help-block"><?php echo form_error('content', '<small class="text-red">', '</small>'); ?></p>
		</div>
		<div class="form-group">
			<label>Kutipan</label>
			<textarea name="excerpt" rows="3" class="form-control"><?php echo (!set_value('excerpt')) ? $post->post_excerpt : set_value('excerpt') ?></textarea>
			<p class="help-block"><?php echo form_error('excerpt', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>Ringkasan adalah tulisan ringkas buatan tangan opsional dari konten yang bisa Anda gunakan dalam tema.</i></small></p>
		</div>
		<div class="form-group">
			 <div class="checkbox">
			     <input name="comment" <?php if($post->comment_status=='open') echo 'checked'; ?> value="open" type="checkbox"> <label for="checkbox1"><strong>Izinkan Komentar</strong></label>
			 </div>
			 <div class="checkbox">
			     <input name="polling" <?php if($post->poll_status=='open') echo 'checked'; ?> value="open" type="checkbox"> <label for="checkbox1"><strong>Izinkan Pengambilan Polling</strong></label>
			 </div>
			<p class="help-block"><?php echo form_error('polling', '<small class="text-red">', '</small>'); ?></p>
		</div>
		<div class="form-group">
			<label>Pertanyaan Polling</label>
			<select name="pollingquestion" id="inputPollingquestion" class="form-control" style="width:50%">
				<option value="">-- PILIH --</option>
			<?php foreach($this->polling->get_all_question() as $row) : ?>
				<option value="<?php echo $row->question_id ?>" <?php $this->cpost->valid_question($post->ID, $row->question_id); ?>><?php echo $row->question; ?></option>
			<?php endforeach; ?>
			</select>
			<p class="help-block"><?php echo form_error('pollingquestion', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>Jika anda mengaktifkan pengambilan poliing, silahkan pilih pertanyaan berikut.</i></small></p>
		</div>
	</div>
	<div class="col-md-3 top4x">
		<div class="form-group text-center">
			<a href="<?php echo base_url("administrator/post"); ?>" class="btn btn-app bg-red"><i class="fa fa-times"></i> Batal</a>
			<button class="btn btn-app bg-blue"><i class="fa fa-save"></i> Simpan</button>
		</div>
		<div class="box box-default">
			<div class="box-header with-border">
				<strong class="box-heading">Pengelompokkkan</strong>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label>Status</label>
					<select name="status" id="inputStatus" class="form-control" required="required">
						<option value="publish" <?php if($post->post_status=='publish') echo 'selected'; ?>>Terbit</option>
						<option value="draft" <?php if($post->post_status=='draft') echo 'selected'; ?>>Konsep</option>
						<option value="pending" <?php if($post->post_status=='pending') echo 'selected'; ?>>Menunggu</option>
					</select>
				</div>	
				<div class="form-group">
					<label>Tipe Berita</label>
					<select name="type" id="inputStatus" class="form-control" required="required">
						<option value="default" <?php if($post->post_type=='default') echo 'selected'; ?>>Standar</option>
						<option value="headline" <?php if($post->post_type=='headline') echo 'selected'; ?>>Utama</option>
					</select>
				</div>	
				<div class="form-group">
					<label>Kategori</label>
					<div class="box-select-category">
					<?php foreach( $this->category->get_parent() as $row)  : ?>
						<div class="checkbox">
						    <input type="checkbox" name="categories[]" <?php echo $this->cpost->valid_category($post->ID, $row->category_id) ?> value="<?php echo $row->category_id ?>"> <label><?php echo $row->name ?></label>
						</div>
						<?php foreach( $this->category->get_child($row->category_id) as $child) : ?>
						<div class="checkbox left3x">
						    <input type="checkbox" name="categories[]" <?php echo $this->cpost->valid_category($post->ID, $child->category_id) ?> value="<?php echo $child->category_id ?>"> <label><?php echo $child->name ?></label>
						</div>
						<?php endforeach; ?>
					<?php endforeach; ?>
					</div>
				</div>	
				<div class="form-group">
					<label>Topik</label>
					<select name="topik[]" id="select-topik" class="form-control" multiple="multiple" data-placeholder="Masukkan Topik berita ...">
						<?php foreach( $this->tags->get_all() as $row ) : ?>
						<option value="<?php echo $row->tag_id; ?>" <?php echo $this->cpost->valid_topik($post->ID, $row->tag_id) ?>><?php echo $row->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>	
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default">
			<div class="box-header with-border">
				<strong class="box-heading">Gambar Utama</strong>
			</div>
			<div class="box-body">
				<div class="form-group">
					<img src="<?php echo $this->posts->get_thumbnail($post->image, 'small'); ?>" alt="Gambar Utama" class="img-responsive">
				</div>
				<div class="form-group">
					<input type="file" name="gambar" class="form-control">
				</div>	
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
