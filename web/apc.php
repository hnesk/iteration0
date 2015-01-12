<?php
/**
 * @author Johannes Künsebeck <jkuensebeck@taz.de>
 * @license proprietary
 * @copyright  2014 contrapress Satz u. Druck GmbH Neue KG
 *
 * Created: 26.11.14 18:32
 */
apc_clear_cache();
apc_clear_cache('user');
apc_clear_cache('opcode');
echo 1;
