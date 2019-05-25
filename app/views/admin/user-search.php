<!-- Membership Search Starts Here -->
<section class="table-area section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>View <?php echo escape(explode('-',$subName)[1]) ?></h3>
                <form class="search-form" action="<?php echo ROOT . $subName ?>" method="post">
                    <div class="search-field-wrapper">
                        <input class="search-field" type="text" name="search"
                               placeholder="Username, Last Name, ID number" onfocus="this.placeholder = ''"
                               onblur="this.placeholder = 'Username, Last Name, ID number'" required>
                    </div>
                    <div class="search-button-wrapper">
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        <button type="submit" name="submit" class="template-btn">search</button>
                    </div>
                </form>
            </div>
        </div>
        <?php if (isset($data['search'])) { ?>
            <div class="row justify-content-center">
                <div class="table-wrap col-lg-12">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th class="head" scope="col">ID</th>
                            <th class="head" scope="col">First Name</th>
                            <th class="head" scope="col">Last Name</th>
                            <th class="head" scope="col">Username</th>
                            <th class="head" scope="col">
                                <?php switch ($subName) {
                                    case 'admin-membership':
                                        echo 'Expiry Date';
                                        break;
                                    case 'admin-members':
                                        echo 'Email';
                                        break;
                                } ?></th>
                            <th class="head" scope="col">Change</th>
                            <th class="head" scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($data['search'])) {
                            foreach ($data['search'] as $user) { ?>
                                <tr>
                                    <td class="name"><?php echo escape($user['u_id']) ?></td>
                                    <td><?php echo ucfirst(escape($user['u_first_name'])) ?></td>
                                    <td><?php echo ucfirst(escape($user['u_last_name'])) ?></td>
                                    <td><?php echo escape($user['u_username']) ?></td>
                                    <?php switch ($subName) {
                                        case 'admin-membership': ?>
                                            <td>
                                                <?php if (isset($user['me_expiry_date'])) {
                                                    echo escape($user['me_expiry_date']);
                                                } else {
                                                    echo "Not subscribed";
                                                } ?>
                                            </td>
                                            <td><a class="template-btn"
                                                   href="<?php echo ROOT . $subName .'/edit/' . escape($user['u_id']) ?>">Edit</a>
                                            </td>
                                            <?php if (isset($user['me_expiry_date'])) { ?>
                                                <td><a class="template-btn"
                                                       href="<?php echo ROOT . $subName .'/cancel/' . escape($user['u_id']) ?>">Cancel</a>
                                                </td>
                                            <?php }
                                            break;
                                        case 'admin-members': ?>
                                            <td> <?php echo escape($user['u_email']) ?> </td>
                                            <td><a class="template-btn"
                                                   href="<?php echo ROOT . $subName . '/edit/' . escape($user['u_id']) ?>">Edit</a>
                                            </td>
                                            <td><a class="template-btn"
                                                   href="<?php echo ROOT . $subName . '/delete/' . escape($user['u_id']) ?>">Delete</a>
                                            </td>
                                            <?php
                                            break;
                                    } ?>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12 admin-navigate-buttons <?php if($subName === 'admin-members'){ echo 'admin-navigate-buttons-flex'; } ?>">
                <div>
                    <a class="template-btn" href="<?php echo ROOT . 'admin' ?>">Back to Admin Panel</a>
                </div>
                <?php if($subName === 'admin-members') {?>
                <div>
                    <a class="template-btn" href="<?php echo ROOT . $subName . '/add' ?>" >Add User</a>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</section>
<!-- Membership Search Ends Here -->