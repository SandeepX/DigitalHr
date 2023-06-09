
<li class="nav-item  {{
                   request()->routeIs('admin.salary-components.*') ||
                   request()->routeIs('admin.payment-methods.*') ||
                   request()->routeIs('admin.payment-currency.*') ||
                   request()->routeIs('admin.salary-tds.*') ||
                   request()->routeIs('admin.salary-salary-groups.*')
                ? 'active' : ''
            }}"
    >
    <a class="nav-link" data-bs-toggle="collapse"
       href="#payroll"
       data-href="#"
       role="button" aria-expanded="false" aria-controls="settings">
        <i class="link-icon" data-feather="gift"></i>
        <span class="link-title"> Payroll Management  </span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="{{
                request()->routeIs('admin.salary-components.*') ||
                request()->routeIs('admin.payment-methods.*') ||
                request()->routeIs('admin.payment-currency.*') ||
                request()->routeIs('admin.salary-salary-groups.*') ||
                request()->routeIs('admin.salary-tds.*')

               ? '' : 'collapse'  }} " id="payroll">

        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="{{route('admin.salary-components.index')}}"
                   data-href="{{route('admin.salary-components.index')}}"
                   class="nav-link {{
                      request()->routeIs('admin.salary-components.*') ||
                      request()->routeIs('admin.payment-methods.*') ||
                      request()->routeIs('admin.payment-currency.*') ||
                      request()->routeIs('admin.salary-salary-groups.*') ||
                      request()->routeIs('admin.salary-tds.*')

                      ? 'active' : ''
                      }}">Payroll Setting
                </a>
            </li>
        </ul>
    </div>
</li>

