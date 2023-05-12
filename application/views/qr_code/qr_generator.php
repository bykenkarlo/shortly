        <!-- Container -->
        <div id="_web_container" class="">
            <div class="mt--10 other-section padding-bottom-30 " >
                <div class="container">
                    <div class="card card-services-highlights pt-2 pb-2 padding-right-30 padding-left-30  mt-4">
                        <div class="row pb-3 pt-2">
                            <div class=" mt-1 pb-2">
                                <h1 class="f-h1 text-center">Qr Code Generator</h1>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div id="generated_qrcode" class="mt-2">
                                </div>
                                <div class="text-center d-flex justify-content-center mt-2">
                                    <div class="me-1">
                                         <button id="_download_qr" class="btn btn-light rounded btn-sm"><i class="uil uil-download-alt"></i> Download</button>
                                    </div>
                                    <div class="">
                                        <button id="_upload_logo" class="btn btn-light rounded btn-sm" onclick="_upload_logo_btn()"><i class="uil uil-upload-alt"></i> Upload Logo</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6 mt-3 ">
                                <textarea class="form-control" name="text" id="text" cols="30" rows="10" placeholder="Enter your URL, Text here..."></textarea>
                                <button class="btn btn-success rounded btn-lg font-18 mt-2 float-end" id="_generate">Generate QR Code</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="other-section padding-bottom-30 c-dwhite">
                <div class="container">
                    <div class="mt-3 text-center" id="features">
                        <h2 class="f-h2">Why Use Shortly Qr Code Generator?</h2>
                        <p class="p-text">Shortly QR code generator is a user-friendly and time-saving tool for creating QR codes for various applications. <br>Effortless, efficient, and convenient!  
                        QR code generators simplify the process of creating QR codes, making it quick and hassle-free.</p>
                    </div>
                </div>
            </div>

            <div class="other-section padding-bottom-30">
                <div class="container">
                    <div class="mt-3 " id="features">
                        <h2 class="f-h2">What is Qr Code Generator? What's the use of it and Benefits of Using it</h2>
                        <p class="p-text">QR code, or Quick Response code, is a two-dimensional barcode that can be scanned and decoded using a smartphone or a QR code reader. It is a type of matrix barcode that stores information in a pattern of black squares on a white background.</p>
                        <p class="p-text">The main purpose of a QR code is to provide a convenient and efficient way to share information or data. QR codes can store various types of information, such as text, URLs, contact information, and more. When scanned, QR codes quickly redirect users to websites, display text messages, initiate phone calls or emails, or provide other types of information.</p>
                        <h2 class="f-h3 mt-3">The benefits of using QR codes include:</h2>
                        <ol>
                            <li>
                                <p class="p-text">Easy and convenient: QR codes are simple to generate, print, and share. Users can quickly scan QR codes using their smartphones without the need for typing or manually entering information.</p>
                            </li>
                            <li>
                                <p class="p-text">Versatile: QR codes can store a wide range of information, making them suitable for various applications in different industries, such as marketing, advertising, product packaging, event promotion, and more.</p>
                            </li>
                            <li>
                                <p class="p-text">Time-saving: QR codes can save time by providing direct access to information, eliminating the need to type in lengthy URLs or contact details.</p>
                            </li>
                            <li>
                                <p class="p-text">Cost-effective: QR codes can be generated and printed inexpensively, making them a cost-effective solution for businesses and individuals to share information.</p>
                            </li>
                            <li>
                                <p class="p-text">Trackable: QR codes can be tracked and monitored, allowing businesses to measure the effectiveness of their marketing campaigns and gather data on customer engagement.</p>
                            </li>
                            <li>
                                <p class="p-text">Enhanced user experience: QR codes can provide interactive and engaging experiences for users, such as accessing exclusive content, participating in promotions, or entering giveaways, creating a positive user experience.</p>
                            </li>
                        </ol>
                        <p class="p-text">QR codes are a versatile and convenient tool for sharing information, and their benefits include ease of use, versatility, time-saving, cost-effectiveness, trackability, and improved user experience.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="_url_stat_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg " >
                <div class="modal-content br-10">
                    <div class="modal-header ">
                        <h4 class="modal-title " id=""><i class="uil uil-chart-line "></i> Check URL Statistics</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                    
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade margin-top-10" id="_upload_custom_logo_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content br-10">
                    <div class="modal-body">
                        <div class="container-fluid">   
                            <h3 class="text-left text-capitalize margin-top-20 fw-300"> <i class="uil uil-upload-alt"></i> Upload Logo</h3>
                            <div class="mb-2">
                                <img alt="Logo image" src="<?=base_url('assets/images/thumbnail.webp')?>" id="_logo_thumbnail" width="220" class="br-10 cursor-pointer" >
                             </div>
                                                
                            <form id="_upload_img_form" class="mb-3">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="custom-file">
                                            <label class="form-label">Your Image</label>
                                            <input onchange="readImageURL(this)" class="form-control" name="logo_img" id="_logo_img" type="file" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                    <input type="hidden" name="url_param" value="<?= ($url_param) ? $url_param : ''?>">
                                    <div class="text-end">
                                        <button class="btn btn-md btn-success rounded" id="_upload_btn" type="submit">Upload</button>
                                        <button class="btn btn-md btn-secondary rounded" id="_close_btn" type="button">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>

        <!-- End Container -->