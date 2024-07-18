<x-header-bottom>
<ul class="sub-category">
    @foreach($categories as $category)
    <li><a href="product-grids.html">{{$category->name}}</a></li>
                                
    @endforeach
    </ul>
</x-header-bottom>