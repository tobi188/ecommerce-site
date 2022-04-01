<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{asset('assets/css/test.css')}}">

@php
    $categories = array();

    foreach($nav as $n){
        $categories[] = $n;
    }
    function showCategories($categories, $parent_id = 0){
        $cate_child = array();
        foreach($categories as $key => $value){
            if($parent_id == $value->parent_id){
                $cate_child[] = $value;
                unset($categories[$key]);
            }
        }
        if($cate_child){
            echo "<ul>";
                foreach($cate_child as $key => $value){
                    echo "<li><a href='#'>" . $value->name . "</a>";
                    showCategories($categories, $value->id);
                    echo "</li>";
                }
            echo "</ul>";
        }
    }
    
@endphp
    <div class="container">
        {{showCategories($categories)}}
    </div>

{{-- <div class="container">
    <ul>
        <li><a href="#">SmartPhone</a></li>
        <li class="sub"><a href="#">PC</a>
            <ul>
                <li><a href="#">MacBook</a>
                    <ul>
                        <li><a href="#">M1 MacBook Air</a></li>
                        <li><a href="#">MacBook Pro</a>
                            <ul>
                                <li><a href="#">MacBook Pro i9</a>
                                    
                                </li> 
                                <li><a href="#">MacBook Pro i7</a></li>
                                <li><a href="#">MacBook Pro i5</a></li>
                                <li><a href="#">MacBook Pro i3</a>
                                    <ul>
                                        <li><a href="#">MacBook Pro i9 2020</a></li>
                                        <li><a href="#">MacBook Pro i9 2018 </a></li>
                                        <li><a href="#">MacBook Pro i9 2016</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">MacBook Air</a></li>
                    </ul>
                </li>
                <li><a href="#">Dell</a></li>
                <li><a href="#">HP</a></li>
                <li><a href="#">MSI</a></li>
            </ul>
        </li>
        <li><a href="#">Gaming Gear</a></li>
        <li><a href="#">Accessories</a></li>
    </ul>
</div> --}}

<script>
    $(document).ready(function () {
        $('li').hover(function() {
            $(this).find('ul:first').slideDown();
        }, function(){
            $(this).find('ul:first').hide();
        });
    });
</script>