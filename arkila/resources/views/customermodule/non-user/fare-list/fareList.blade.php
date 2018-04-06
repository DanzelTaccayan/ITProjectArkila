@extends('layouts.customer_non_user')
@section('content')
               <div class="row packages">
                <div class="col-md-3">
                  <div class="package">
                    <div class="package-header light-gray">
                      <h5>Basic</h5>
                    </div>
                    <div class="price">
                      <div class="price-container d-flex align-items-end justify-content-center">
                        <h4 class="h1"><span class="currency">$</span>7</h4><span class="period">/ month</span>
                      </div>
                    </div>
                    <ul class="list-unstyled">
                      <li><i class="fa fa-check"></i>100GB Storage</li>
                      <li><i class="fa fa-check"></i>Own config file</li>
                      <li><i class="fa fa-times"></i>Sharing Tools</li>
                      <li><i class="fa fa-times"></i>Auto Backup</li>
                      <li><i class="fa fa-times"></i>Extended Security</li>
                    </ul><a href="#" class="btn btn-template-outlined">Sign Up</a>
                  </div>
                </div>
                <!-- / END FIRST PACKAGE-->
                <div class="col-md-3">
                  <div class="package">
                    <div class="package-header light-gray">
                      <h5>Standard</h5>
                    </div>
                    <div class="price">
                      <div class="price-container d-flex align-items-end justify-content-center">
                        <h4 class="h1"><span class="currency">$</span>21</h4><span class="period">/ month</span>
                      </div>
                    </div>
                    <ul class="list-unstyled">
                      <li><i class="fa fa-check"></i>100GB Storage</li>
                      <li><i class="fa fa-check"></i>Own config file</li>
                      <li><i class="fa fa-times"></i>Sharing Tools</li>
                      <li><i class="fa fa-times"></i>Auto Backup</li>
                      <li><i class="fa fa-times"></i>Extended Security</li>
                    </ul><a href="#" class="btn btn-template-outlined">Sign Up</a>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="best-value">
                    <div class="package">
                      <div class="package-header bg-primary color-white">
                        <div class="content">
                          <h5>Premium</h5>
                          <div class="meta-text">Best Value</div>
                        </div>
                      </div>
                      <div class="price-container d-flex align-items-end justify-content-center">
                        <h4 class="h1"><span class="currency">$</span>53</h4><span class="period">/ month</span>
                      </div>
                      <ul class="list-unstyled">
                        <li><i class="fa fa-check"></i>100GB Storage</li>
                        <li><i class="fa fa-check"></i>Own config file</li>
                        <li><i class="fa fa-times"></i>Sharing Tools</li>
                        <li><i class="fa fa-times"></i>Auto Backup</li>
                        <li><i class="fa fa-times"></i>Extended Security</li>
                      </ul><a href="#" class="btn btn-template-outlined">Sign Up</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="package">
                    <div class="package-header light-gray">
                      <h5>Ultimate</h5>
                    </div>
                    <div class="price-container d-flex align-items-end justify-content-center">
                      <h4 class="h1"><span class="currency">$</span>99</h4><span class="period">/ month</span>
                    </div>
                    <ul class="list-unstyled">
                      <li><i class="fa fa-check"></i>100GB Storage</li>
                      <li><i class="fa fa-check"></i>Own config file</li>
                      <li><i class="fa fa-times"></i>Sharing Tools</li>
                      <li><i class="fa fa-times"></i>Auto Backup</li>
                      <li><i class="fa fa-times"></i>Extended Security</li>
                    </ul><a href="#" class="btn btn-template-outlined">Sign Up</a>
                  </div>
                </div>
              </div>
              <!-- Packages End-->
@endsection