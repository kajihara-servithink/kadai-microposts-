@if(Auth::id() ==$user->id)
    <div class='mt-4'>
        <form method='POST' action='{{ route('microposts.store')}}'>
            @csrf
            
            <div class'form-contorol mt-4'>
                <texterea rows='2' name='content' class='input input-bordedred w-full'></texterea>
            </div>
            
            <button type='submit' class='btn btn-primary btn-block normal-case'>Post</button>
        </form>
    </div>
@endif