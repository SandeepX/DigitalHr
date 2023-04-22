
    <div class="row">
        @foreach($permissionGroupList as $key=>$value)
            <div class="col-lg-3 mb-3">
                <div class="group-checkbox">
                    <div class="head-checkbox">
                        <div class="title-ch mb-2">
                            <h6>{{$value->name}} Module:</h6>
                        </div>

                        <div class="checkAll">
                            <label class="label-ch">
                                <input class="js-check-all" type="checkbox" name=""
                                       data-check-all="website">
                                <span class="text">Check All</span>
                            </label>
                        </div>
                    </div>
                    <ul class="js-check-all-target list-ch" data-check-all="website">
                        @foreach($value->getPermission as $keys => $permission)
                            @php
                                $checked='';
                                if(count($role_permission) > 0){
                                    if(in_array($permission->id,$role_permission)){
                                        $checked = "checked = 'checked'";
                                    }
                                }
                            @endphp
                            <li class="item">
                                <label class="label">
                                    <input class="module_checkbox"
                                           type="checkbox"
                                           id="{{$permission->permission_key}}"
                                           name="permission_value[]"
                                           value="{{$permission->id}}"
                                        {{$checked}}>
                                    <span class="text">{{$permission->name}}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>


    <div class="text-right">
        <button type="submit" class="btn btn-success btn-md">
            {{$isEdit ? 'Update': 'Save'}}
        </button>
    </div>
