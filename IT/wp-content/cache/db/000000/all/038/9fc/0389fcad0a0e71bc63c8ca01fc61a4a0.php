RûMV<?php exit; ?>a:6:{s:10:"last_error";s:0:"";s:10:"last_query";s:324:"
					SELECT sd_term_taxonomy.term_taxonomy_id
					FROM sd_term_taxonomy
					INNER JOIN sd_terms USING (term_id)
					WHERE taxonomy = 'post_format'
					AND sd_terms.slug IN ('post-format-quote','post-format-aside','post-format-video','post-format-gallery','post-format-link','post-format-status','post-format-chat')
				";s:11:"last_result";a:0:{}s:8:"col_info";a:1:{i:0;O:8:"stdClass":13:{s:4:"name";s:16:"term_taxonomy_id";s:7:"orgname";s:16:"term_taxonomy_id";s:5:"table";s:16:"sd_term_taxonomy";s:8:"orgtable";s:16:"sd_term_taxonomy";s:3:"def";s:0:"";s:2:"db";s:11:"sedesgro_wp";s:7:"catalog";s:3:"def";s:10:"max_length";i:0;s:6:"length";i:20;s:9:"charsetnr";i:63;s:5:"flags";i:49699;s:4:"type";i:8;s:8:"decimals";i:0;}}s:8:"num_rows";i:0;s:10:"return_val";i:0;}