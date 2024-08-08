<button class="rightbottom" type="button" onclick="myFunction()">مساعده</button>
	<div class="right widget-contact col-md-3" id="form1" >
								<h4 class="widget-title ">طلب <i class="fa fa-close left " onclick="myFunction1()"></i></h4>
								<form action="{{route('contact.store')}}" method="POST" accept-charset="utf-8" >
									@csrf
									<div class="form-ft">
										
											 	
												<input type="text" placeholder="@lang('website.name')" value="{{ old('name') }}" name="name"  required>
												
									 
												<input type="email" placeholder="@lang('website.email')" value="{{ old('email') }}" name="email" required>
										 	
										 
										
										<input type="text" placeholder="@lang('website.subject')" value="{{ old('subject') }}" name="subject" required>
										
									
											<textarea name="message"  placeholder="@lang('website.message')" required cols="40" rows="10"></textarea>
										
										
											<button type="submit" class="btn-contact-ft btn-block">ارسال</button>
										
									</div><!-- /.form-ft -->
								</form><!-- /form -->
							</div><!-- /.widget widget-contact -->
	</div><!-- boxed -->

   
   <script>
function myFunction() {
  var x = document.getElementById("form1");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
   <script>
function myFunction1() {
  var x = document.getElementById("form1");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
    <div class="icon-bar">
          <a href="https://api.whatsapp.com/send?phone=966580549190&text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%20%D8%B4%D8%B1%D9%83%D8%A9%20%D8%B6%D9%85%D8%A7%D9%86%D9%89" class="WhatsApp"><img src="https://dammany.com/assets/website/images/WhatsApp.png" /></a> 
   </div>
	</div><!-- boxed -->
