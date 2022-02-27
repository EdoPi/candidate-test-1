<div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $order->title) }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Description</label>
          <input type="text" name="description" class="form-control" value="{{ old('description', $order->description) }}">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Cost</label>
          <input type="text" name="cost" class="form-control" value="{{ old('cost', number_format($order->cost, 2)) }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Customer</label>
          <select class="form-select form-control" name="customer_id">
            <option selected>Open this select menu</option>
            @foreach($customers as $customer)
                <option value="{{$customer->id}}" {{isset($customerChosen) && $customer->id == $customerChosen->id ? 'selected' : ""}}>{{$customer->first_name . " " . $customer->last_name}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-6">
          <h5>Tags:</h5>
        <div class="form-check">
            @foreach ($tags as $tag)
            <div>
                <input class="form-check-input" type="checkbox" name="tag_id[]" value="{{$tag->id}}" {{isset($tagsChecked) && in_array($tag->id, $tagsChecked) ? 'checked' : ""}}>
                <label class="form-check-label" for="inlineCheckbox1">{{$tag->name}}</label>
            </div>
            @endforeach
        </div>
      </div>
    </div>
    <br>
