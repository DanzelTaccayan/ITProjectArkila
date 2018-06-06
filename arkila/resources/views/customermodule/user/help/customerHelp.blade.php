@extends(Auth::user() ? 'layouts.customer_user' : 'layouts.customer_non_user')
@section('links')
@parent
<style>
    .question-list{
        margin-bottom: 10%;
    }
    .question-item{
        margin-bottom: 3%;
    }
</style>
@endsection
@section('content')
<section class="mainSection">
        <div class="col-md-8 mx-auto">
            <div class="heading text-center">
                <h2>FAQs</h2>
            </div>
            <div class="box box-solid boxContainer">
                <div class="box-body">
                    <h4>YOUR ACCOUNT</h4>
                    <div class="question-list">  
                        <div class="question-item">  
                            <p><strong>Why should I sign up?</strong></p>
                            <p>By signing up, you will be able to access the full features of the system such as renting of vans, line reservations, viewing of transactions and many more.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>Can I request for a rental/reservation without signing in?</strong></p>
                            <p>You need to first sign in in order to request for a rental or reservation.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>How do I sign up?</strong></p>
                            <p><strong>1.</strong>	Click on the sign-up button at the upper right of the navigation bar.</p>
                            <p><strong>2.</strong>	Enter the necessary information and click the sign-up button.</p>
                            <p><strong>3.</strong>	A message will be shown telling you to check your email to verify your account. </p>
                            <p><strong>4.</strong>	In that email, click on the Verify Email button.</p>
                            <p><strong>5.</strong>	A success message will be shown showing that you have successfully signed up.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>How do I recover my password?</strong></p>
                            <p><strong>1.</strong>	Click on the forgot your password button in the sign in page.</p>
                            <p><strong>2.</strong>	Provide your email address where your new password will be sent.</p>
                            <p><strong>3.</strong>	An email will be sent to you. In that email click on the Reset Password button.</p>
                            <p><strong>4.</strong>	Provide your email on the following page including your new password.</p>
                        </div>
                    </div>
                    <h4>RESERVATION/RENTAL</h4>
                    <div class="question-list">
                        <div class="question-item">  
                            <p><strong>How to rent a van online?</strong></p>
                            <p><strong>1.</strong>	Click on the rent now button on the home page or the rentals button under the services tab.</p>
                            <p><strong>2.</strong>	Provide the necessary information and click on the book button at the bottom of the page.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>Is there a walk-in rental booking?</strong></p>
                            <p>	Yes, you can book at the station by arranging a rental with the clerk.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>How to reserve a line?</strong></p>
                            <p><strong>1.</strong>	Click on the reserve now button on the home page or the reservation button under the services tab.</p>
                            <p><strong>2.</strong>	Select a destination and click on the show reservations button</p>
                            <p><strong>3.</strong>	If there is an open reservation, click on the reserve button in the table.</p>
                            <p><strong>4.</strong>	Make sure all the information is correct and then enter your contact number and the desired quantity of tickets and then click on the reserve button.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>How to view your rentals/reservations</strong></p>
                            <p><strong>1.</strong>	Click on the My Account tab on the upper right of the navigation bar.</p>
                            <p><strong>2.</strong>	Click on the My Transactions button.</p>
                            <p><strong>3.</strong>	Toggle between the Rentals and Reservations tab to view your transactions.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>Can I refund?</strong></p>
                            <p>Yes, you can refund your tickets at the clerk in the terminal.</p>
                        </div>
                        <div class="question-item">  
                            <p><strong>How do I reach you?</strong></p>
                            <p>You can reach us by getting our contact details on the about us page of our website.</p>
                        </div>
                    </div>
                    <h4>PAYMENTS</h4>
                    <div class="question-list"> 
                        <div class="question-item">  
                            <p><strong>How can I pay?</strong></p>
                            <p>You can pay by going to the cashier at the terminal. Our address is in the about us page.</p>
                        </div>
                    </div>
                    <h4>JOB</h4>
                    <div class="question-list"> 
                        <div class="question-item">
                            <p><strong>I want to be a driver. Can I apply for the job?</strong></p>
                            <p>We’d love to work with you. Please reach out to us. Our contact information is in the about us page.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- col-->
    </section>
    <!--    main section-->
@stop