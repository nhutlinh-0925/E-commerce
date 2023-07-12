{{-- them san pham --}}
@extends('back-end.main')

@section('head')
    {{--  <script src="/ckeditor/ckeditor.js"></script>  --}}
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/flag-icon/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/quill.bubble.css">
@endsection

@section('content')

<div class="col s12 m12 l12">
    <div id="placeholder" class="card card card-default scrollspy">
      <div class="card-content">
        <h4 class="card-title">Thêm danh mục sản phẩm</h4>
        <form>
          <div class="row">
            <div class="input-field col s12">
              <input placeholder="John Doe" id="name2" type="text">
              <label for="name2">Tên danh mục sản phẩm</label>
            </div>
          </div>
          <div class="row">
            {{--  <div class="input-field col s12">
              <input placeholder="john@domainname.com" id="email2" type="email">
              <label for="email">Mô tả danh mục</label>
            </div>  --}}
            <div class="col s12">
                <label for="name2">Mô tả danh mục sản phẩm</label>
                <div class="card">
                  {{--  <div class="card-content">  --}}

                    {{--  <h4 class="card-title">Snow Editor</h4>
                    <p class="mb-1">Snow is a clean, flat toolbar theme.</p>  --}}
                    <div class="row">
                      <div class="col s12">
                        <div id="snow-wrapper">
                          <div id="snow-container">
                            <div class="quill-toolbar">
                              <span class="ql-formats">
                                <select class="ql-header browser-default">
                                  <option value="1">Heading</option>
                                  <option value="2">Subheading</option>
                                  <option selected="">Normal</option>
                                </select>
                                <select class="ql-font browser-default">
                                  <option selected="">Sailec Light</option>
                                  <option value="sofia">Sofia Pro</option>
                                  <option value="slabo">Slabo 27px</option>
                                  <option value="roboto">Roboto Slab</option>
                                  <option value="inconsolata">Inconsolata</option>
                                  <option value="ubuntu">Ubuntu Mono</option>
                                </select>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-formula"></button>
                                <button class="ql-code-block"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-clean"></button>
                              </span>
                            </div>
                            <div class="editor">
                              {{--  <h1 class="ql-align-center">Quill Rich Text Editor</h1>
                              <p><br></p>
                              <p>
                                Quill is a free, <a href="../../../../quilljs/quill/index.htm">open source</a> WYSIWYG editor
                                built for the modern web. With its <a href="../../../../docs/modules/index.htm">modular
                                  architecture</a> and expressive <a href="../../../../docs/api/index.htm">API</a>, it is
                                completely customizable to fit any need.
                              </p>
                              <p><br></p> --}}
                              <br><br><br><br><br>
                              {{--  <iframe class="ql-video ql-align-center" width="560" height="1000">
                              </iframe>  --}}


                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {{--  </div>  --}}
              </div>
          </div>

          <div class="row">
            <div class="row">
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  {{--  <script>  --}}
    {{--  CKEDITOR.replace('content');  --}}
    <script src="/template/back-end/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="/template/back-end/vendors/quill/katex.min.js"></script>
    <script src="/template/back-end/vendors/quill/highlight.min.js"></script>
    <script src="/template/back-end/vendors/quill/quill.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="/template/back-end/js/plugins.min.js"></script>
    <script src="/template/back-end/js/search.min.js"></script>
    <script src="/template/back-end/js/custom/custom-script.min.js"></script>
    <script src="/template/back-end/js/scripts/customizer.min.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="/template/back-end/js/scripts/form-editor.min.js"></script>
  {{--  </script>  --}}
@endsection
