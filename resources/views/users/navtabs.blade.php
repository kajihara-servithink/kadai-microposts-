<div class='tabs tabs-lifted'>
    {{---ユーザー詳細タブ  --}}
    <a href='{{route('users.show',$user->id)}}'class='tab grow {{ Request::routeIs('users.show')?'tab-active': ' '}}'>
        Timeline
        <div class='dadge badge-netutral ml-1'>{{$user->microposts_count}}</div>
    </a>
    {{---フォロー一覧タブ  ---}}
    <a href='{{route('users.followings',$user->id)}}'class='tab grow {{ Request::routeIs('users.followings')?'tab-active': ' '}}'>
        Followings
        <div class='dadge badge-netutral ml-1'>{{$user->followings_count}}</div>
     </a>
     {{---フォロー一覧タブ  ---}}
     <a href='{{route('users.followers',$user->id)}}'class='tab grow {{ Request::routeIs('users.followers')?'tab-active': ' '}}'>
        Followers
         <div class='dadge badge-netutral ml-1'>{{$user->followers_count}}</div>
    </a>
</div>