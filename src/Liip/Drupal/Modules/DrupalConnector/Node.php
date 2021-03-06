<?php

/**
 * Abstraction of the procedural Drupal world into OOP.
 *
 * @author     Bastian Feder <drupal@bastian-feder.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright  Copyright (c) 2012 liip ag
 *
 * @package    DrupalConnector
 * @subpackage Node
 */

namespace Liip\Drupal\Modules\DrupalConnector;

/**
 * Cumulates the node functions of Drupal 7 in one class.
 *
 * Please order the functions alphabetically!
 */
class Node
{
    /**
     * Determine whether the current user may perform the given operation on the
     * specified node.
     *
     * @param string    $op      The operation to be performed on the node. Possible values are:
     *                            - "view"
     *                            - "update"
     *                            - "delete"
     *                            - "create"
     * @param \stdClass $node    The node object on which the operation is to be performed,
     *                            or node type (e.g. 'forum') for "create" operation.
     * @param \stdClass $account Optional, a user object representing the user for whom the operation is to be
     *                            performed. Determines access for a user other than the current user.
     *
     * @return boolean TRUE if the operation may be performed, FALSE otherwise.
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_access/7
     */
    public function node_access($op, $node, $account = null)
    {
        return node_access($op, $node, $account);
    }

    /**
     * Delete a node.
     *
     * @param integer $nid A node ID.
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_delete/7
     */
    public function node_delete($nid)
    {
        node_delete($nid);
    }

    /**
     * Retrieves the timestamp at which the current user last viewed the
     * specified node.
     *
     * @param integer $nid The node ID.
     *
     * @return \stdClass
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_last_viewed/7
     */
    public function node_last_viewed($nid)
    {
        return node_last_viewed($nid);
    }

    /**
     * Load a node object from the database.
     *
     * @param integer $nid   The node ID.
     * @param integer $vid   The revision ID.
     * @param boolean $reset Whether to reset the node_load_multiple cache.
     *
     * @return \stdClass|false A fully-populated node object, or FALSE if the node is not found.
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_load/7
     */
    public function node_load($nid = null, $vid = null, $reset = false)
    {
        return node_load($nid, $vid, $reset);
    }

    /**
     * Decide on the type of marker to be displayed for a given node.
     *
     * @param integer $nid       Node ID whose history supplies the "last viewed" timestamp.
     * @param integer $timestamp Time which is compared against node's "last viewed" timestamp.
     *
     * @return integer One of the MARK constants.
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_mark/7
     */
    public function node_mark($nid, $timestamp)
    {
        return node_mark($nid, $timestamp);
    }

    /**
     * Save changes to a node or add a new node.
     *
     * @param \stdClass &$node The $node object to be saved. If $node->nid is omitted (or $node->is_new is TRUE), a new node will be added.
     *
     * @throws \Liip\Drupal\Modules\DrupalConnector\NodeException in case the node could not be persisted.
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_save/7
     */
    public function node_save(&$node)
    {
        try {
            node_save($node);
        } catch (\Exception $e) {
            throw new NodeException(
                sprintf(NodeException::FailedToSaveNodeText, $node->nid),
                NodeException::FailedToSaveNode,
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Update the 'last viewed' timestamp of the specified node for current user.
     *
     * @param \stdClass $node A node object.
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_tag_new/7
     */
    public function node_tag_new($node)
    {
        node_tag_new($node);
    }

    /**
     * Gathers a listing of links to nodes.
     *
     * @param object $result A database result object from a query to fetch node entities. If your query joins the
     *                       {node_comment_statistics} table so that the comment_count field is available,
     *                       a title attribute will be added to show the number of comments.
     * @param string $title  A heading for the resulting list.
     *
     * @return array A renderable array containing a list of linked node titles fetched from $result,
     *                or FALSE if there are no rows in $result.
     *
     * @link          http://api.drupal.org/api/drupal/modules!node!node.module/function/node_title_list/7
     */
    public function node_title_list($result, $title = null)
    {
        return node_title_list($result, $title);
    }

    /**
     * Prepares a manually created node and adds drupal specific properties to it (uid, status etc.)
     *
     * @param $node \stdClass   The $node object which will have the properties added to it
     * @return void
     */
    public function node_object_prepare(\stdClass $node)
    {
        node_object_prepare($node);
    }

    /**
     * Generate an array for rendering the given node.
     *
     * @param \stdClass $node     A node object.
     * @param string    $viewMode View mode, e.g. 'full', 'teaser'...
     * @param string    $langCode (optional) A language code to use for rendering. Defaults to the global content
     *                            language of the current request.
     *
     * @return array An array as expected by drupal_render().
     *
     * @link http://api.drupal.org/api/drupal/modules!node!node.module/function/node_view/7
     */
    public function node_view($node, $viewMode = 'full', $langCode = null)
    {
        return node_view($node, $viewMode, $langCode);
    }

    /**
     * Updates the database cache of node types.
     *
     * All new module-defined node types are saved to the database via a call to
     * node_type_save(), and obsolete ones are deleted via a call to
     * node_type_delete(). See _node_types_build() for an explanation of the new
     * and obsolete types.
     *
     * @see _node_types_build()
     */
    function node_types_rebuild() {
        node_types_rebuild();
    }

    /**
     * Deletes multiple nodes.
     *
     * @param $nids
     *   An array of node IDs.
     */
    function node_delete_multiple($nids) {
        node_delete_multiple($nids);
    }

    /**
     * Deletes a node type from the database.
     *
     * @param $type
     *   The machine-readable name of the node type to be deleted.
     */
    function node_type_delete($type) {
        node_type_delete($type);
    }

    /**
     * Implements hook_form().
     */
    function node_content_form($node, $form_state) {
        return node_content_form($node, $form_state);
    }

    /**
     * Prepares node for saving by populating author and creation date.
     *
     * @param $node
     *   A node object.
     *
     * @return
     *   An updated node object.
     */
    function node_submit($node) {
        return node_submit($node);
    }

    /**
     * Loads node entities from the database.
     *
     * This function should be used whenever you need to load more than one node
     * from the database. Nodes are loaded into memory and will not require database
     * access if loaded again during the same page request.
     *
     * @see entity_load()
     * @see EntityFieldQuery
     *
     * @param array $nids
     *   An array of node IDs.
     * @param array $conditions
     *   (deprecated) An associative array of conditions on the {node}
     *   table, where the keys are the database fields and the values are the
     *   values those fields must have. Instead, it is preferable to use
     *   EntityFieldQuery to retrieve a list of entity IDs loadable by
     *   this function.
     * @param boolean $reset
     *   Whether to reset the internal node_load cache.
     *
     * @return array
     *   An array of node objects indexed by nid.
     */
    public function node_load_multiple(array $nids, array $conditions = array(), $reset = false)
    {
        return node_load_multiple($nids, $conditions, $reset);
    }
}
