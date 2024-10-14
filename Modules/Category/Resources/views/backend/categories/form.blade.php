<div class="row mb-3">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = "name";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = "slug";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = "group_name";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-8">
        <div class="form-group">
            <?php
            $field_name = "image";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->input("file", $field_name)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>

    @if ($data && $data->getMedia($module_name)->first())
        <div class="col-4">
            <div class="float-end">
                <figure class="figure">
                    <a
                        href="{{ asset($data->$field_name) }}"
                        data-lightbox="image-set"
                        data-title="Path: {{ asset($data->$field_name) }}"
                    >
                        <img
                            src="{{ asset($data->getMedia($module_name)->first()->getUrl("thumb300"),) }}"
                            class="figure-img img-fluid img-thumbnail rounded"
                            alt=""
                        />
                    </a>
                    <!-- <figcaption class="figure-caption">Path: </figcaption> -->
                </figure>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="image_remove"
                        id="image_remove"
                        name="image_remove"
                    />
                    <label class="form-check-label" for="image_remove">Remove this image</label>
                </div>
            </div>
        </div>
        <x-library.lightbox />
    @endif
</div>
<div class="row">
    <div class="col-12 mb-3">
        <div class="form-group">
            <?php
            $field_name = "description";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = "meta_title";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = "meta_keyword";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = "meta_description";
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = "status";
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";
            $required = "required";
            $select_options = \Modules\Category\Enums\CategoryStatus::toArray();
            ?>

            {{ html()->label($field_lable, $field_name)->class("form-label") }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->class("form-select")->attributes(["$required"]) }}
        </div>
    </div>
</div>
