<!-- Schedule Area Starts -->
<section class="schedule-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-top text-center">
                    <h3>Upcoming Classes</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="table-wrap col-lg-10">
                <table class="schdule-table table">
                    <thead class="thead-light">
                    <tr>
                        <th class="head" scope="col">Course name</th>
                        <th class="head" scope="col">Date</th>
                        <th class="head" scope="col">Time</th>
                        <th class="head" scope="col">Duration</th>
                        <th class="head" scope="col">Trainer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($data['schedule'])) {
                        foreach ($data['schedule'] as $class) { ?>
                            <tr>
                                <th class="name" scope="row"><?php echo escape($class['cl_name']); ?></th>
                                <td><?php ?></td>
                                <td>10.00</td>
                                <td>02.00</td>
                                <td>02.00</td>
                                <td><a class="template-btn" href="">Sign up</a></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Schedule Area End -->