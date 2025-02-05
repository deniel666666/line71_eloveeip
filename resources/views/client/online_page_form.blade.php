            <!-- 簡易問答 -->
            <div class="online-page mb-4">
              <div class="qa-items-box detect-box contact">
                <ul>
                  @foreach($productType as $q_index=>$q)
                    <li class="item question" question_type="{{$q['type_price']}}">
                      <div class="form-group">
                        <label for='question_{{$q_index}}' class="title">
                        <!-- {{$q_index+1}}. -->
                        <span>{{$q['prod_type']}}</span>
                        @if($q['type_sales_price']==1)<span class="mark input_require">(必填)</span>@endif
                        </label>

                        @if($q['type_price']==0)
                        <!-- 單選題 -->
                        @foreach( explode(',', $q['prod_sn']) as $sn_index=>$sn)
                          <div class="form-check detect-ans">
                            <input class="form-check-input" type="radio" name="question_{{$q_index}}" id="question_{{$q_index}}_{{$sn_index}}" value="{{$sn}}">
                            <label class="form-check-label" for="question_{{$q_index}}_{{$sn_index}}">{{$sn}}</label>
                          </div>
                        @endforeach
                        @endif

                        @if($q['type_price']==1)
                        <!-- 多選題 -->
                        @foreach( explode(',', $q['prod_sn']) as $sn_index=>$sn)
                          <div class="form-check detect-ans">
                            <input class="form-check-input" type="checkbox" name="question_{{$q_index}}" id="question_{{$q_index}}_{{$sn_index}}" value="{{$sn}}">
                            <label class="form-check-label" for="question_{{$q_index}}_{{$sn_index}}">{{$sn}}</label>
                          </div>
                        @endforeach
                        @endif

                        @if($q['type_price']==2)
                          <!-- 文字題 -->
                          <input class="form-control" type="text" name="question_{{$q_index}}" id="question_{{$q_index}}">
                        @endif

                        @if($q['type_price']==3)
                          <!-- 檔案題 -->
                          <input class="form-control question_file" type="file" name="question_{{$q_index}}" id="question_{{$q_index}}">
                          <input class="form-control" type="hidden" name="question_{{$q_index}}_fileName" id="question_{{$q_index}}_fileName">
                          <input class="form-control" type="hidden" name="question_{{$q_index}}_fileData" id="question_{{$q_index}}_fileData">
                        @endif
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <!-- 一般回函表 -->
            <div class="online-page mb-4">
              <!-- <h5 class="font-subtitle mb-4">歡迎線上報名，我們於24小時內收到您的資料後，將由服務專員立即與您聯繫相關事宜。</h5> -->
              <div class="contact form row">
                <input type="hidden" ng-model="contCtrl.model.contact.online_class" readonly>
                <input type="hidden" ng-model="contCtrl.model.contact.online_text" readonly>
                <input type="hidden" ng-model="contCtrl.model.contact.online_type" readonly>

                <!--
                  <div class="form-group col-md-6">
                    <label for="">姓名 <span class="mark">(必填)</span></label>
                    <input type="text" class="form-control" ng-model="contCtrl.model.contact.contaName">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="cont-mail">信箱</label>
                    <input type="mail" class="form-control" ng-model="contCtrl.model.contact.contaEmail">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="cont-phone">電話<span class="mark">(必填)</span></label>
                    <input type="text" class="form-control" ng-model="contCtrl.model.contact.contaPhone">
                  </div>
                  
                  <div class="form-group col-md-12 use-form-row">
                    <label for="">我有話要說...</label>
                    <textarea rows="5" class="form-control" ng-model="contCtrl.model.contact.contaContent"></textarea>
                  </div>
                -->
                <div class="form-group verificationBox col-md-12">
                  <label class="verificationCode cont-title">
                    <span><span class="mark">※</span>驗證碼</span>
                    <span class="remindLabel"></span>
                  </label>
                  <div id="formVerification"></div>
                  <p id="verificationCodeOK" class="validation-notice-1 d-none">請填寫正確驗證碼</p>
                </div>
                <div class="submitBox col-12">
                  <button id="check-contact-btn" type="button submit" class="submitBtn text-white" ng-click="contCtrl.submitContact()">送出</button>
                </div>
              </div>
            </div>