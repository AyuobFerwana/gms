@extends('lgs.dashbord')

@section('title', 'Create')
@section('Large-title', 'Create Clothes')

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .remove-margin {
            margin: 0;
        }

        .inline-inputs-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
        }

        .inline-inputs {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .third-width {
            width: 30%;
        }

        .custom-file-label::after {
            background-color: #4E73DF;
            color: #fff;
            content: "Choose Image" !important;
        }

        .add-color {
            border: none;
            background: none;
            color: #4E73DF;
        }
    </style>
@endsection

@section('container')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create</h4>
                <form class="forms-sample" onsubmit="event.preventDefault();  performEdit()" id="form">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <input type="text" class="form-control" id="name" value="{{ $product->name }}"
                            placeholder="Product">
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <div id="colors-container">
                            <input type="color" value="{{ $product->colors[0] }}" class="form-control" id="color">
                            @foreach ($product->colors as $color)
                                @if (!$loop->first)
                                    <input type="color" value="{{ $color }}" class="form-control"
                                        id="color_{{ $loop->iteration - 1 }}">
                                @endif
                            @endforeach
                        </div>
                        <button type="button" onclick="addColor()" class="add-color">Add Color &plus;</button>
                        <button type="button" onclick="resetColors()" class="add-color" style="margin-left: 20px;">Clear
                            Colors</button>
                    </div>

                    <div class="inline-inputs-container">
                        <div class="col-md-4">
                            <div class="form-group third-width">
                                <label for="size">Size</label>
                                <select class="select2" multiple="multiple" name="checkbtu" id="size"
                                    data-placeholder="Select a Size" style="width: 230%;">
                                    <option value="S" @selected(in_array('S', $product->sizes))>S</option>
                                    <option value="M" @selected(in_array('M', $product->sizes))>M</option>
                                    <option value="L" @selected(in_array('L', $product->sizes))>L</option>
                                    <option value="XL" @selected(in_array('XL', $product->sizes))>XL</option>
                                    <option value="XXL" @selected(in_array('XXL', $product->sizes))>XXL</option>
                                    <option value="XXXL" @selected(in_array('XXXL', $product->sizes))>XXXL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group third-width inline-inputs">
                            <label for="Price" class="remove-margin">Prise</label>
                            <div class="form-group remove-margin" style="width: 100%;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white">$</span>
                                    </div>
                                    <input type="text" id="price" class="form-control"
                                        aria-label="Amount (to the nearest dollar)" value="{{ $product->price }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            </select>
                        </div>
                        <div class="form-group third-width">
                            <input type="number" class="form-control" id="quantity" value="{{ $product->quantity }}"
                                placeholder="Quantity">
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label for="exampleInputFile">Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('corona/js/file-upload.js') }}"></script>
    <script>
        let colors = {{ count($product->colors) - 1 }};

        function performEdit() {
            swal.showLoading();
            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', document.getElementById('name').value);
            formData.append('color', document.getElementById('color').value);
            formData.append('sizes', getSelectSizes());
            formData.append('price', document.getElementById('price').value);
            formData.append('quantity', document.getElementById('quantity').value);

            if (document.getElementById('image').files.length > 0) {
                formData.append('image', document.getElementById('image').files[0]);
            }

            formData.append('colors', colors);

            for (let i = 1; i <= colors; i++) {
                formData.append('color_' + i, document.getElementById('color_' + i).value);
            }

            axios.post('{{ route('products.update', $product) }}', formData)
                .then(function(response) {
                    toastr.success(response.data.message);
                    console.log(response);
                    swal.close();
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                    swal.close();
                });
        }

        function addColor() {
            const colorInput = document.createElement("input");
            colorInput.setAttribute('type', 'color');
            colorInput.setAttribute('value', '#000000');
            colorInput.setAttribute('class', 'form-control');
            colorInput.setAttribute('id', `color_${++colors}`);
            document.getElementById('colors-container').appendChild(colorInput);
            // <input type="color" value="#000000" class="form-control" id="color">
        }

        function resetColors() {
            const colorInput = document.createElement("input");
            colorInput.setAttribute('type', 'color');
            colorInput.setAttribute('value', '#000000');
            colorInput.setAttribute('class', 'form-control');
            colorInput.setAttribute('id', `color`);
            document.getElementById('colors-container').innerHTML = '';
            document.getElementById('colors-container').appendChild(colorInput);
            colors = 0;
        }

        function getSelectSizes() {
            let select = document.getElementById('size');
            var result = [];
            var options = select && select.options;
            var opt;

            for (var i = 0, iLen = options.length; i < iLen; i++) {
                opt = options[i];

                if (opt.selected) {
                    result.push(opt.value || opt.text);
                }
            }
            return result;
        }
    </script>
@endsection
