<form method="post" action="{{ route('coupons.update', $coupon->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-12">
            <label for="name" class="form-control-label">{{__('Name')}}</label>
            <input type="text" name="name" class="form-control" required value="{{$coupon->name}}">
        </div>

        <div class="form-group col-md-6">
            <label for="discount" class="form-control-label">{{__('Discount')}}</label>
            <input type="number" name="discount" class="form-control" required step="0.01" value="{{$coupon->discount}}">
            <span class="small">{{__('Note: Discount in Percentage')}}</span>
        </div>
        <div class="form-group col-md-6">
            <label for="limit" class="form-control-label">{{__('Limit')}}</label>
            <input type="number" name="limit" class="form-control" required value="{{$coupon->limit}}">
        </div>
        <div class="form-group col-md-12" id="auto">
            <div class="row">
                <div class="col-md-10">
                    <input class="form-control" name="code" type="text" id="auto-code" value="{{$coupon->code}}">
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn btn-xs btn-icon-only width-auto" id="code-generate"><i class="fas fa-history"></i> {{__('Generate')}}</a>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12">
            <input type="submit" class="btn-create badge-blue" value="{{__('Update')}}">
            <input type="button" class="btn-create bg-gray" data-dismiss="modal" value="{{__('Cancel')}}">
        </div>
    </div>
</form>

