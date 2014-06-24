<?php
namespace Bll;

use Bll\SimpleObject\Post;
use Lib\Paging;

class Posts extends Component
{
	private $exists_tables;
	public function getPopular(Paging $paging)
	{
		$postIds 	= $this->getApplication()->db->web->sql2array('SELECT SQL_CALC_FOUND_ROWS * FROM `posts_active` ORDER BY rating DESC ' . $paging->getSqlPatch().' ');
		$totalFound = $this->getApplication()->db->web->selectSingle('SELECT FOUND_ROWS()');
		$posts	 	= $this->getPostsByIds($postIds);
		return array($posts, $totalFound);
	}

	/**
	 * @param $postId
	 * @param $authorId
	 * @return Post
	 */
	public function getById($postId, $authorId)
	{
		$postIds = $this->getApplication()->db->web->sql2array(
			'SELECT SQL_CALC_FOUND_ROWS *
				FROM `posts_aids__' . ($authorId % 20) . '`
			 	WHERE author_id=? AND post_id=?
			',
			array(
				$authorId,
				$postId
			)
		);

		$posts = $this->getPostsByIds($postIds);

		return $posts ? array_pop($posts) : null;
	}

	public function getPostsByIds($ids, $table = 'posts_data', $data_where = '', $create_table_if_not_exists = true, $short = false, $idField = 'id')
	{
		$posts    = array();
		$toFetch = array();
		// sharding
		;
		if ($table == 'posts_data') {
			foreach ($ids as $data) {
				$_table              = $this->addTableForDate(isset($data['pub_date']) ? $data['pub_date'] : $data['pub_time'], $create_table_if_not_exists);
				$_table              = str_replace('dates', 'data', $_table);
				$toFetch[$_table][] = $data;
			}
		} else {
			foreach ($ids as $data) {
				$toFetch[$table][] = $data;
			}
		}

		foreach ($toFetch as $table => $ids) {
			$in_post_ids = $in = array();
			foreach ($ids as $data) {
				$in[]          = '(' . $data['post_id'] . ',' . $data['author_id'] . ')';
				$in_post_ids[] = '(' . $data['post_id'] . ')';
			}
			if ($short)
				$short = ',T.has_content as text,\'\' as `short`';
			$q = 'SELECT
                T.*' . $short . ',A.name,A.id as author_id, A.has_pic as author_has_pic
                    ,TH.name as theme_name,TH.title as theme_title
                    FROM `' . $table . '` T
                        LEFT JOIN themes TH ON TH.id=T.auto_theme_id
                        LEFT JOIN author A ON T.author_id=A.id
                        WHERE T.' . $idField . ' IN (' . implode(',', $in_post_ids) . ') AND
                        (T.' . $idField . ',author_id) IN (' . implode(',', $in) . ')';

			if ($data_where)
				$q .= ' AND ' . $data_where;
			$raw = $this->application->db->web->sql2array($q);
			foreach ($raw as $row) {
				$posts[] = new \Bll\SimpleObject\Post($row);
			}
		}
		return $posts;
	}

	public function addTableForDate($date, $create_table_if_not_exists = true) {
		$table_name = 'posts_dates__' . date('Y_m', $date);
		if ($create_table_if_not_exists && !$this->tableExists($table_name)) {
			$this->application->db->web->query('CREATE TABLE `' . $table_name . '` (`post_id` INT NOT NULL ,`author_id` INT NOT NULL ,`pub_time` INT NOT NULL ,PRIMARY KEY ( `post_id` , `author_id`) ,INDEX (`pub_time` )) ENGINE = InnoDB;');
		}
		return $table_name;
	}

	private function tableExists($table) {
		if (!$this->exists_tables) {
			$tables = $this->application->db->web->sql2array('SHOW TABLES');
			foreach ($tables as $row)
				$this->exists_tables[$row['Tables_in_ljtop']] = 1;
		}
		if (!isset($this->exists_tables[$table])) {
			$this->exists_tables[$table] = 1;
			return false;
		}
		return true;
	}



}