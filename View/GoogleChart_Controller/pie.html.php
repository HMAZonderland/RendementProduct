<!--Div that will hold the pie chart-->
<div class="chart_wrapper">
    <h2>Marketingkanaal omzet verdeling</h2>
    <div id="chart_div">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="<?=JAVASCRIPT_ROOT?>googlechart.functions.js"></script>
        <script type="text/javascript">
            load('<?=$this->model->chart_data?>');
        </script>
    </div>
</div>
