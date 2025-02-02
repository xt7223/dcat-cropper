@php
    $optionsObject=json_decode($options);
    $optionsObject->elementName;
    $column=$optionsObject->elementName;
@endphp
<div x-data2="weiwait_cropper()" x-init2="_init({{$options}}, '{{$column}}')">
    <div class="{{$viewClass['form-group']}} {{ $class }}">

        <label for="{{$column}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

        <div class="{{$viewClass['field']}}">
            @include('admin::form.error')

            <div class="web-uploader clearfix {{ $fileType }}">

                <div style="display: flex; flex-wrap: wrap;">
                    <template x-for="(image, ii) in images">
                        <div class="img-thumbnail cropped-img-contain"
                             draggable="true"
                             x-on:dragover.throttle.500ms="croppedDragover(ii)"
                             x-on:dragstart="currentDrag = ii">

                            <img x-bind:src="image.preview"
                                 class="cropped-img"
                                 x-on:click="prepareCropper(image, ii)"
                                 draggable="false">

                            <input name="{{ $name }}" x-bind:value="image.uri" type="hidden"/>
                        </div>
                    </template>

                    <label x-show="images.length < 1" id="{{$column}}-img-pick" class="img-thumbnail cropped-img-contain">
                        <div>
                            <span style="font-size: 100px; color: #a6a6a6">+</span>
                        </div>

                        <input x-model="pickInput"
                               x-bind:accept="accept"
                               type="file"
                               x-on:change="selected"
                               style="display: none"
                               id="{{$column}}-img-input" />
                    </label>
                </div>
            </div>

            @include('admin::form.help-block')
        </div>
    </div>

    <div x-show="modalShow" x-transition.opacity.duration.200ms style="position: fixed; top: 0; left: 0; z-index: 9999; height: 100vh; width: 100vw; display: none;">
        <div style="display: flex; justify-content: center; align-items: center; height: 100%;" x-on:click.self="next()">
            <div style="width: 960px; background-color: white; box-shadow: #cccccc 4px 6px 10px; border-radius: 10px;">
                <div style="height: 540px;">
                    <img x-bind:src="croppingData" id="croppingImg-{{$column}}" alt="" style="display: block; max-width: 100%; width: 100%;">
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="..." style="margin: 0 0 0 20px">
                        <button type="button" class="btn btn-info" x-bind:class="modeActive === 'move' ? 'active' : ''" x-on:click="changeMode('move')">
                            <span class="fa fa-arrows-alt"></span>
                        </button>
                        <button type="button" class="btn btn-info" x-bind:class="modeActive === 'crop' ? 'active' : ''" x-on:click="changeMode('crop')">
                            <span class="fa fa-crop" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="btn-group" role="group" aria-label="..." style="margin: 0 0 0 10px">
                        <button type="button" class="btn btn-info" x-on:click="black()">黑白</button>
                        <button type="button" class="btn btn-info" x-on:click="targetUp()">↑</button>
                        <button type="button" class="btn btn-info" x-on:click="targetDown()">↓</button>
                        <button type="button" class="btn btn-info" x-on:click="targetLeft()">←</button>
                        <button type="button" class="btn btn-info" x-on:click="targetRight()">→</button>
                        <button type="button" class="btn btn-info" x-on:click="Cropper.reset()">重置</button>
                        <button type="button" class="btn btn-info" x-on:click="deleteCropped()">删除</button>
                        <button type="button" class="btn btn-info" x-on:click="targetChange()">更换</button>
                    </div>

                    <div class="btn-group" role="group" aria-label="..." style="margin: 0 0 0 10px">
                        <button type="button" class="btn btn-info" x-on:click="original()">原图</button>
                        <button type="button" class="btn btn-info" x-on:click="cropping()">裁剪</button>
                    </div>

                    <div class="dropdown" x-show="Object.keys(ratios).length > 0">
                        <button class="btn btn-info dropdown-toggle"
                                type="button"
                                id="dropdownMenuButton"
                                data-toggle="dropdown"
                                aria-expanded="false"
                                x-text="currentRatio">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <template x-for="(v, key) in ratios">
                                <div class="dropdown-item"
                                     style="padding: 5px 10px"
                                     x-on:click="changeRatio(v, key)"
                                     x-text="key">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
