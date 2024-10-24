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
  <!-- <div class="categories">
    <i class="fa fa-list" aria-hidden="true"></i> ALL BOOK CATEGORIES
    <ul>
      <?php 
        // require_once("./configs/app-config.php");
        // require_once("./classes/Database.php");
  
        // $db = new Database($appConfig);
        // $result = $db->getCategories();
        // $string = "<li><a href='/home.php'>All</a></li>";
        
        // for($i=0; $i < count($result); ++$i) {
        //   $name = $result[$i]['name'];
        //   $string = $string."<li><a href='?category=".$name."'>".$name."</a></li>";
        // }

        // echo $string;
      ?>
    </ul>
  </div>  -->
</div>
<script>
  (function(){
    const nav = document.querySelector('.navigation .nav');
    const properties = [
      { name: 'Home', url: '/index.php', icon: "fa fa-home"}, 
      { name: 'My Cart & Orders', url: '/cart.php', icon: "fa fa-shopping-cart"},
      { name: 'About Us', url: '/aboutus.php', icon: "fa fa-question-circle"},
      { name: 'Contact Us', url: '/contactus.php', icon: "fa fa-phone-square"},
    ];

    const isAdmin = <?= isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : 0 ?>;

    if(isAdmin)
      properties.push({ name: 'Manage', url: '/manage.php', icon: "fa fa-pencil-square" });

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