<select class="custom-select">
<option value="" selected>All Companies</option>
<?php foreach($companies as $key => $company): ?>
    <option value="{{$key}}">{{$company['name']}}</option>
<?php endforeach; ?>
</select>