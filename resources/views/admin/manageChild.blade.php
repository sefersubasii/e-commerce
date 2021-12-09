 @foreach($childs as $child)
     @if(@$data->id!=$child->id)
     <option {{@$data->parent_id==$child->id ? "selected" : ""}} value="{{$child->id}}">
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