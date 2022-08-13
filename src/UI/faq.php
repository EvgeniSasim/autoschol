<?php 
    $title = $args['zagolovok'];
    $subTitle = $args['opisanie_sekczii'];
    $accordionList = $args['spisok'];
    $bg_color = $args['bg_color'] === 'blue' ? 'bg-section_blue' : '';
?>
<section class="faq-section <?php echo $bg_color; ?>">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="faq-subtitle">
            <h5><?php echo $subTitle; ?></h5>
        </div>
        <div class="accordion-list">
            <?php foreach ($accordionList as $key => $item) { ?>
            <div class="accordin-list__item">
                <div class="accordin-list__item__title">
                    <h5><?php echo $item['vidite_vopros']; ?></h5>
                </div>
                <div class="accordin-list__item__descr">
                    <?php echo $item['vvidite_otvet']; ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<script>
    
///////////////* Accordion *//////////////////
const accordion = () => {
  let accordion = document.querySelector(".accordion-list");
  let accordinTitle = accordion.querySelectorAll(".accordin-list__item__title");
  let accordinItems = accordion.querySelectorAll(".accordin-list__item");
  const toggleAccordion = (index) => {
    let thisItem = index;
    accordinItems.forEach((item, index) => {
      if (thisItem == index) {
        item.classList.toggle("active");
        return;
      }
      item.classList.remove("active");
    });
  };
  accordinTitle.forEach((question, index) => {
    question.addEventListener("click", () => {
      toggleAccordion(index);
    });
  });
};
accordion();
</script>