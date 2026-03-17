<?php 
/**
 * Breadcrumbs for tax terms
 */
class MultiCrumbs
{
    private $object_id;
    private $taxonomy_slug;
    private $multicrumb_li_class;

    public function __construct($taxonomy_slug) {

        $this->taxonomy_slug = $taxonomy_slug;
        $this->multicrumb_li_class = 'multicrumb-item';
        add_action('storefront_before_content', [$this, 'outputCrumbs']);
    }

    public function outputCrumbs()
    {
        if(!is_tax($this->taxonomy_slug)) {
            return;
        }
        $this->object_id = get_queried_object_id();

        ob_start();

        ?>

        <div class="multicrumbs">

            <ul class="multicrumbs-ul">
                
                <li class="<?php echo $this->multicrumb_li_class; ?>"><a href="/">Home</a></li>

                <?php echo $this->getParentTermHtml(); ?>
                
                <?php echo $this->getChildTermsHtml(); ?>

                <li class="<?php echo $this->multicrumb_li_class; ?>"><a href="/">Static Link</a></li>

            </ul>

        </div>

        <?php
        echo ob_get_clean();

    }

    public function getParentTermHtml()
    {
        $parent_term_id = $this->getParentTerm();

        $parent_term = get_term_by( 'term_id', $parent_term_id, $this->taxonomy_slug);

        if(!$parent_term || is_wp_error($parent_term)) {
            return '';
        }

        ob_start(); ?>

        <li class="<?php echo $this->multicrumb_li_class; ?>"><a href="<?php echo get_term_link($parent_term); ?>"><?php echo $parent_term->name; ?></a></li>

        <?php
        return ob_get_clean();

    }

    public function getParentTerm()
    {
        $term = get_term_by( 'term_id', $this->object_id, $this->taxonomy_slug);

        $termParent = ($term->parent == 0) ? false : $term->parent;

        if(!$termParent) {
            return;
        }

        return $termParent;
    }

    public function getChildTerms()
    {
        return get_term_children($this->object_id , $this->taxonomy_slug);
    }

    public function getChildTermsHtml()
    {
        $term_ids = $this->getChildTerms();

        if(!$term_ids) {
            return '';
        }

        ob_start();

        foreach($term_ids as $term_id) : ?>

            <?php $term = get_term_by( 'term_id', $term_id, $this->taxonomy_slug); ?>

            <?php if($term && !is_wp_error($term)) : ?>

                <?php //var_dump($term); ?>

                <li class="<?php echo $this->multicrumb_li_class; ?>"><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></li>

            <?php endif; ?>

        <?php endforeach;

        return ob_get_clean();
    }

}

add_action('init', function(){
    new MultiCrumbs('product_cat');
});
