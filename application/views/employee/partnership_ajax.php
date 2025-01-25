<div class="row" id="div_<?php echo $key; ?>">
<div class="col-md-2 form-group">
<label for="name">Partner Name<span class="text-danger">*</span></label>
<input type="text" class="form-control" id="partner_names" name="partner_names[]" placeholder="Enter Name" required>
</div>
<div class="col-md-3 form-group">
<label for="name">Partner Father Name<span class="text-danger">*</span></label>
<input type="text" class="form-control" id="partner_father_names" name="partner_father_names[]" placeholder="Enter Father Name" required>
</div>
<div class="col-md-2 form-group">
<label for="cat_slno" class="control-label">Partner Mobile <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="partner_mobiles" name="partner_mobiles[]" placeholder="Enter mobile" required>
</div>
<div class="col-md-2 form-group">
<label for="cat_slno" class="control-label">Partner Email <span class="text-danger">*</span></label>
<input type="email" class="form-control" id="partner_emails" name="partner_emails[]" placeholder="Enter email" required>
</div>
<div class="col-md-2 form-group">
<label for="cat_slno" class="control-label">Partner Pan Number <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="partner_pan_numbers" name="partner_pan_numbers[]" placeholder="Enter Pan Number" required>
</div>
<div class="col-md-1 form-group">
&nbsp; <br>
<button type="button" class="btn btn-danger" onclick="removeDiv(<?php echo $key; ?>)"><i class="fa fa-times"></i></button>
</div>
</div>