<div>
    @include('backstage.partials.tables.top')
    <div class="flex flex-col">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full overflow-hidden">
                @if($resource == 'games')
                <form class="grid grid-cols-4 gap-4 md:grid-cols-6" method="get" action="{{url()->current()}}">
                    @include('backstage.partials.forms.text', ['label' => 'Account', 'field' => 'search', 'value' => request()->filled('search') ? request()->search : null, 'message' => null])

                    @include('backstage.partials.forms.select', ['label' => 'Criteria', 'field' => 'criteria', 
                    'options' => ['account'=>"Search By Account", 
                                  'prize'=>"Search By Prize ID", 
                                  'hour_greater'=>"Search By Hour (greater)", 
                                  'hour_less'=>"Search By Hour (less)"], 
                    'message' => null, 'value' =>  request()->filled('criteria') ? request()->criteria : null])

                    <div class="pt-5">
                        <input style="background:linear-gradient(0deg, rgba(81, 182, 255, 1) 0%, rgba(78, 147, 255, 1) 90%);" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" value="Search" type="submit"/>
                    </div>
                </form>
                <hr/>
                @endif
                <table class="min-w-full mt-5">
                    @include('backstage.partials.tables.headers')

                    @include('backstage.partials.tables.body')
                </table>
            </div>
        </div>
    </div>
    @include('backstage.partials.tables.footer')

</div>

@push('js')
    <script>
        window.livewire.on('deleteResource', function(url, resource){
            swal({
                title: "Are you sure you want to delete this "+resource+"?",
                text: "The data will be permanently removed from our servers forever. This action cannot be undone!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "No",
                        value: false,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        className: 'swal-delete-button',
                        text: "Yes",
                        value: true,
                        visible: true,
                        closeModal: false,
                    },
                },
            }).then(doDelete => {
                if(doDelete) {
                    axios.post(url, { _method: 'delete' })
                        .then(function (response) {
                            swal({
                                title: "Success!",
                                text: "The "+resource+" has been removed.",
                                icon: "success",
                                buttons: false,
                                timer: 1000,
                            });
                            window.livewire.emit('resourceDeleted');
                        });
                }
            });
        });
    </script>
@endpush
