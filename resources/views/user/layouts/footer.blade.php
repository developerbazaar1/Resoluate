<footer class="footer mg-t-auto resolute-footer " id="footer">
  <div>
    <span> Copyright &copy; Resolute Contract Solution 2023  </span>
    
  </div>
  <div>
    <nav class="nav">
     
      <a href="" class="nav-link">Terms & Conditions</a>
      <a href="" class="nav-link">Privacy Policy</a>
    </nav>
  </div>
</footer>

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/feather-icons/feather.min.js') }}"></script>
<script src="{{ URL::asset('assets/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ URL::asset('assets/js/dashforge.js') }}"></script>
<script src="{{ URL::asset('assets/js/dashboard-two.js') }}"></script>
<script src="{{ URL::asset('assets/js-cookie/js.cookie.js') }}"></script>
<script src="{{ URL::asset('assets/js/dashforge.settings.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom-js/dashboardchart.js') }}"></script>
<script src="{{ URL::asset('assets/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('assets/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/dashforge.chat.js') }}"></script>  
<script src="{{ URL::asset('assets/js/dashforge.aside.js') }}"></script> 
<script>
      // Adding placeholder for search input
      (function($) {

        'use strict'

        var Defaults = $.fn.select2.amd.require('select2/defaults');

        $.extend(Defaults.defaults, {
          searchInputPlaceholder: ''
        });

        var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

        var _renderSearchDropdown = SearchDropdown.prototype.render;

        SearchDropdown.prototype.render = function(decorated) {

          // invoke parent method
          var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

          this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

          return $rendered;
        };

      })(window.jQuery);


      $(function(){
        'use strict'

        // Basic with search
        $('.select2').select2({
          placeholder: 'Add Team On Workflow + ',
          searchInputPlaceholder: 'Search options'
        });

        // Disable search
        $('.select2-no-search').select2({
          minimumResultsForSearch: Infinity,
          placeholder: 'Choose one'
        });

        // Clearable selection
        $('.select2-clear').select2({
          minimumResultsForSearch: Infinity,
          placeholder: 'Choose one',
          allowClear: true
        });

        // Limit selection
        $('.select2-limit').select2({
          minimumResultsForSearch: Infinity,
          placeholder: 'Choose one',
          maximumSelectionLength: 3
        });

      });
    </script>
    <script>
      $(function(){
        'use strict'

        if(window.matchMedia('(min-width: 768px)').matches) {
          $('body').addClass('show-sidebar-right');
          $('#showMemberList').addClass('active');
        }

        window.darkMode = function(){
          $('.btn-white').addClass('btn-dark').removeClass('btn-white');
        }

        window.lightMode = function() {
          $('.btn-dark').addClass('btn-white').removeClass('btn-dark');
        }

        var hasMode = Cookies.get('df-mode');
        if(hasMode === 'dark') {
          darkMode();
        } else {
          lightMode();
        }
      })
    </script>
    <script> 
        setInterval(function() {
        // scrollToBottom();
      
        $.ajax({
            url: "{{route('get-pcv-email-data')}}",
            type: "get", 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            success: function(data){
              console.log('sent');
            }
        });
        }, 86400000); 
    </script> 
    
    
    
    @yield('scripts')
    