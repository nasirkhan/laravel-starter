<div class="py-10" x-data="{ commentBlock: false }">
    <div class="container mx-auto px-5">
        <h3 class="text-xl">
            @if($$module_name_singular->comments->count())
            <span class="mr-2">{{$$module_name_singular->comments->count()}}</span>
            @endif

            @lang('Comments')
        </h3>
        @guest
        <div class="py-10 flex justify-center">
            <div>
                <a href="{{route('login')}}?redirectTo={{url()->current()}}" class="btn btn-primary">{{__('Login & Write comment')}}</a>
            </div>
        </div>
        @else
        <div class="flex justify-center mx-auto">
            <div>
                <button class="btn btn-primary" @click="commentBlock = !commentBlock">{{__('Write a comment')}}</button>
            </div>
        </div>

        <div x-show="commentBlock" x-collapse>
            <div>
                <div class="flex justify-center mx-auto">
                    <div class="text-center py-10">
                        Your comment will be in the moderation queue. If your comment will be approved, you will get notification and it will be displayed here.
                        <br>
                        Please submit once & wait till published.
                    </div>
                </div>

                {{ html()->form('POST', route("frontend.comments.store"))->class('form')->open() }}
                <div class="mb-6">
                    <?php
                    $field_name = 'name';
                    $field_lable = "Subject";
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>
                    {{ html()->label($field_lable, $field_name)->class(' mb-2 text-sm font-medium text-gray-900 dark:text-gray-300') }} {!! fielf_required($required) !!}
                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500')->attributes(["$required"]) }}
                </div>

                <div class="mb-6">
                    <?php
                    $field_name = 'comment';
                    $field_lable = "Comment";
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>
                    {{ html()->label($field_lable, $field_name)->class(' mb-2 text-sm font-medium text-gray-900 dark:text-gray-300') }} {!! fielf_required($required) !!}
                    {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500')->attributes(["$required", "rows"=>"4"]) }}
                </div>

                <?php
                $field_name = 'post_id';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "required";
                ?>
                {{ html()->hidden($field_name)->value(encode_id($$module_name_singular->id))->attributes(["$required"]) }}

                <?php
                $field_name = 'user_id';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "required";
                ?>
                {{ html()->hidden($field_name)->value(encode_id(auth()->user()->id))->attributes(["$required"]) }}

                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                {{ html()->form()->close() }}
            </div>

            <div>
                <div class="mt-5">
                    @php
                    $comments_all = $$module_name_singular->comments;
                    $comments_level1 = $comments_all->where('parent_id','');
                    @endphp

                    @foreach ($comments_level1 as $comment)

                    <div class="flex flex-col my-10">
                        <div>
                            <a href="#" class="block p-6  bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                <h4 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{$comment->name}}
                                </h4>
                                <div class="font-normal text-gray-700 dark:text-gray-400">
                                    {!!$comment->comment!!}
                                </div>
                            </a>
                        </div>

                        @php
                        $comments_of_comment = $comments_all->where('parent_id', $comment->id);
                        @endphp

                        @if ($comments_of_comment)
                        @foreach ($comments_of_comment as $comment_reply)
                        <div class="ml-4 my-4">
                            <a href="#" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                <div class="font-normal text-gray-700 dark:text-gray-400">
                                    {!!$comment_reply->comment!!}
                                </div>
                            </a>
                        </div>

                        @endforeach
                        @endif

                        @guest
                        <a href="{{route('login')}}?redirectTo={{url()->current()}}" class="btn btn-primary btn-sm float-end m-0"><i class="fas fa-user-shield"></i> Login & Reply</a>
                        @else
                        <div class="mt-4">
                            {{ html()->form('POST', route("frontend.comments.store"))->class('form flex flex-row')->open() }}

                            <?php
                            $field_name = 'parent_id';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->hidden($field_name)->value(encode_id($comment->id))->attributes(["$required"]) }}

                            <?php
                            $field_name = 'post_id';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->hidden($field_name)->value(encode_id($$module_name_singular->id))->attributes(["$required"]) }}

                            <?php
                            $field_name = 'user_id';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->hidden($field_name)->value(encode_id(auth()->user()->id))->attributes(["$required"]) }}

                            <?php
                            $field_name = 'name';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->hidden($field_name)->value("Reply of ".$comment->name)->attributes(["$required"]) }}
                            {{ html()->hidden($field_name)->value(encode_id(auth()->user()->id))->attributes(["$required"]) }}

                            <div class="flex-auto mx-4">
                                <?php
                                $field_name = 'comment';
                                $field_lable = "Reply";
                                $field_placeholder = $field_lable;
                                $required = "required";
                                ?>
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500')->attributes(["$required"]) }}
                            </div>

                            <div>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </div>

                            {{ html()->form()->close() }}
                        </div>
                        @endguest
                    </div>

                    @endforeach
                </div>
            </div>
        </div>

        @endguest
    </div>
</div>