<style>
  .categories {
    position: relative;
    background-color: var(--bg-light-highlight);
    padding: 1rem;
    font-weight: 400;
    display: flex;
    align-items: center;
    border-top-left-radius: .4rem;
    border-top-right-radius: .4rem;
    width: fit-content;
    cursor: pointer;
    font-size: 1.3rem;
    z-index: 2;
    width: 246px;
    margin-right: 1px;
  }

  .categories > i {
    padding-right: 1rem;
  }

  .categories > ul {
    font-size: 1rem;
    visibility: hidden;
    width: 100%;
    list-style: none;
    position: absolute;
    top: 100%;
    left: 0;
    box-shadow:1px 1px 3px 1px #CCC, 1px 1px 3px 1px #CCC;
    opacity: 0;
    transition: opacity 500ms;
  }

  .categories:hover > ul {
    visibility: visible;
    opacity: 1;
    transition: opacity 500ms;
  }

  .categories > ul > li {
    font-size: 1.2rem;
    background-color:  var(--background-cream);
    padding: .5rem 1rem;
  }

  .categories > ul > li:hover {
    background-color: var(--background-white-smoke);
  }

  .navigation {
    display: flex;
    padding-bottom: 0;
    align-items: flex-end;
    justify-content: space-between;
    padding-top: 0;
  }

  .navigation .nav {
    list-style-type: none;
    display: flex;
    font-size: 1.5rem;
    font-weight: 400;
    text-transform: UPPERCASE;
  }

  .navigation .nav > li {
    margin-right: .5rem;
    color: var(--bg-light-highlight);
  }
  
  .navigation .nav > li.active {
    border-top-left-radius: .4rem;
    border-top-right-radius: .4rem;
    background-color: var(--white);
    color: var(--color-black);
    margin-left: 1px;
    /* color: var(--bg-light-highlight);
    border-bottom: solid .2rem var(--white); */
  }

  .navigation .nav > li > a {
    display: block;
    padding: .7rem 1rem;
    text-decoration: none;
    color: inherit;
  }
</style>
<div class="navigation bmb-container">
  <nav>
    <ul class="nav">
    </ul>
  </nav>
</div>
<script>
  (function(){
    const nav = document.querySelector('.navigation .nav');
    const properties = [
      { name: 'Home', url: '/index.php', icon: "fa fa-home"}, 
      { name: 'My Cart & Orders', url: '/cart.php', icon: "fa fa-shopping-cart"},
    ];

    const isAdmin = <?= isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : 0 ?>;
    const isAuthorized = <?= isset($_SESSION['isAuthorized']) ? $_SESSION['isAuthorized'] : 0 ?>;
    const isReseller = <?= isset($_SESSION['isReseller']) ? $_SESSION['isReseller'] : 0 ?>;

    if(!isAuthorized) {
      properties.push(
        ...[
          { name: 'About Us', url: '/aboutus.php', icon: "fa fa-question-circle"},
          { name: 'Contact Us', url: '/contactus.php', icon: "fa fa-phone-square"}
        ]
      );
    }
    if(isAuthorized && !isAdmin && !isReseller)
      properties.push({ name: 'Profile', url: '/profile.php', icon: "fa fa-user" });

    if(isAdmin && !isReseller)
      properties.push({ name: 'Admin', url: '/manage.php', icon: "fa fa-cog" });
    
    if(isAdmin || isReseller)
      properties.push({ name: 'Sales', url: '/sales.php', icon: "fa fa-money" });

    const elems = properties.map(({name, url, icon}) => {
      const isActive = (!window.location.href.includes('php') && name === 'Home')
                        || window.location.href.toLowerCase().includes(url);
          
      const li = document.createElement('li');

      if(isActive) li.classList.add('active');

      const link = document.createElement('a');
      link.setAttribute('href', url);

      link.innerHTML = `<i class="${icon}" aria-hidden="true"></i> ${name}</a>`;

      li.appendChild(link);

      return li;
    });

    for(let li of elems) {
      nav.appendChild(li);
    }
  })();
</script>