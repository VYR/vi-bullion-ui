<div class="row" id="div_<?php echo $key; ?>">
<div class="col-md-2 form-group">
<label for="name">Director Name<span class="text-danger">*</span></label>
<input type="text" class="form-control" id="director_names" name="director_names[]" placeholder="Enter Name" required>
</div>
<div class="col-md-3 form-group">
<label for="name">Director Father Name<span class="text-danger">*</span></label>
<input type="text" class="form-control" id="director_father_names" name="director_father_names[]" placeholder="Enter Father Name" required>
</div>
<div class="col-md-2 form-group">
<label for="cat_slno" class="control-label">Director Mobile <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="director_mobiles" name="director_mobiles[]" placeholder="Enter mobile" required>
</div>
<div class="col-md-2 form-group">
<label for="cat_slno" class="control-label">Director Email <span class="text-danger">*</span></label>
<input type="email" class="form-control" id="director_emails" name="director_emails[]" placeholder="Enter email" required>
</div>
<div class="col-md-2 form-group">
<label for="cat_slno" class="control-label">Director Pan Number <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="director_pan_numbers" name="director_pan_numbers[]" placeholder="Enter Pan Number" required>
</div>
<div class="col-md-1 form-group">
&nbsp; <br>
<button type="button" class="btn btn-danger" onclick="removeDiv(<?php echo $key; ?>)"><i class="fa fa-times"></i></button>
</div>
</div>