<div x-data2="weiwait_cropper()" x-init2="_init({{$options}}, '{{$column}}')">
    <div class="{{$viewClass['form-group']}} {{ $class }}">

        <label for="{{$column}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

        <div class="{{$viewClass['field']}}">
            @include('admin::form.error')

            <div class="web-uploader clearfix {{ $fileType }}">

                <div
                        style="display: grid; grid-template-columns: repeat(auto-fill, 190px); justify-content: space-between; gap: 10px;">
                    <template x-for="(image, ii) in images" x-bind:key="image.id">
                        <div class="img-thumbnail cropped-img-contain"
                             draggable="true"
                             x-transition:enter="transition ease-out duration-1000"
                             x-on:dragover.throttle.500ms="croppedDragover(ii)"
                             x-on:dragstart="currentDrag = ii">

                            <img class="cropped-img"
                                 draggable="false"
                                 x-bind:src="image.preview"
                                 x-on:click="prepareCropper(image, ii)">

                            <input name="{{ $name }}[]" x-bind:value="image.uri" type="hidden"/>
                        </div>
                    </template>

                    <label id="{{$column}}-img-pick" class="img-thumbnail cropped-img-contain">
                        <div>
                            <span style="font-size: 100px; color: #a6a6a6">+</span>
                        </div>

                        <input id="{{$column}}-img-input"
                               type="file"
                               style="display: none"
                               x-model="pickInput"
                               x-bind:accept="accept"
                               x-bind:multiple="multiple"
                               x-on:change="selected"/>
                    </label>
                </div>
            </div>

            @include('admin::form.help-block')
        </div>
    </div>

    <div x-show="modalShow" x-transition.opacity.duration.200ms
         style="position: fixed; top: 0; left: 0; z-index: 9999; height: 100vh; width: 100vw; display: none;">
        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
            <div style="width: 960px; background-color: white; box-shadow: #cccccc 4px 6px 10px; border-radius: 10px;">
                <div class="modal-header">
                    <h4 class="modal-title">图片剪裁</h4>
                    <button type="button" class="close" x-on:click="next()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div style="height: 540px;">
                    <img x-bind:src="croppingData" id="croppingImg-{{$column}}" alt=""
                         style="display: block; max-width: 100%; width: 100%;">
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="..." style="margin: 0 0 0 20px">
                        <button type="button" class="btn btn-light"
                                x-bind:class="modeActive === 'move' ? 'active' : ''"
                                x-on:click="changeMode('move')">
                            <span class="fa fa-arrows-alt"></span>
                        </button>
                        <button type="button" class="btn btn-light"
                                x-bind:class="modeActive === 'crop' ? 'active' : ''"
                                x-on:click="changeMode('crop')">
                            <span class="fa fa-crop" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="btn-group" role="group" aria-label="..." style="margin: 0 0 0 10px">
                        <button type="button" class="btn btn-light" x-on:click="targetUp()">↑</button>
                        <button type="button" class="btn btn-light" x-on:click="targetDown()">↓</button>
                        <button type="button" class="btn btn-light" x-on:click="targetLeft()">←</button>
                        <button type="button" class="btn btn-light" x-on:click="targetRight()">→</button>
                        <button type="button" class="btn btn-light" x-on:click="Cropper.reset()">重置</button>
                        <button type="button" class="btn btn-light" x-on:click="deleteCropped()">删除</button>
                        <button type="button" class="btn btn-light" x-on:click="targetChange()">更换</button>
                    </div>

                    <div class="btn-group" role="group" aria-label="..." style="margin: 0 0 0 10px">
                        <button type="button" class="btn btn-primary"
                                x-on:click="original()" x-show="!is_cropping">
                            原图上传
                        </button>

                        <button type="button" class="btn btn-info" x-show="is_cropping">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </button>

                        <button type="button" class="btn btn-outline-primary"
                                x-on:click="cropping()"
                                x-show="!is_cropping">
                            裁剪上传
                        </button>

                        <button type="button" class="btn btn-info" x-show="is_cropping">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>

                    <div class="dropdown" x-show="Object.keys(ratios).length > 0">
                        <button class="btn btn-light dropdown-toggle"
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
