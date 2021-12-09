@foreach($childs as $child)
    @if(@$data->id!=$child->id)
        <option {{@$child->id==$article->category_id?'selected':''}} {{@$data->parent_id==$child->id ? "selected" : ""}} value="{{$child->id}}">
            @for($i=0; $i<$count; $i++)-->@endfor
            {{ $child->title }}
        </option>
        @if(count($child->childs))
            <?php $count++; ?>
            @include('admin.manageChild',['childs' => $child->childs,'count'=>$count])
            <?php $count--; ?>
        @endif

    @endif
@endforeach
<?php $count=0; ?>