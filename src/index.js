import { registerBlockType } from '@wordpress/blocks';

const { __ } = wp.i18n;


// let quizes = [];
//
// wp.apiFetch({path: "wp/v2/quizzes"}).then(fetchedQuizes => {
// 	quizes = fetchedQuizes;
// }).catch();

let quizes = [
	{
		"id": 6,
		"title": {
			"rendered": "second quiz"
		},

	},
	{
		"id": 5,
		"title": {
			"rendered": "First Quiz"
		},
	}
]

import './style.scss';

/**
 * Internal dependencies
 */
// import Edit from './edit';
import save from './save';
import edit from './edit';


registerBlockType('gutenberg-block/mcqapp', {

	title: __( 'MCQ App', ' mcq-question' ),
	icon: 'list-view',
	keywords: [
		__('Block ', ''),
	],
	attributes:{
		page: {
			type: 'integer',
			default: 0
		},
		quizes : {
			type: "array",
			default: []
		}
	},

	/**
	 * @see ./edit.js
	 */

	edit: edit,

	/**
	 * @see ./save.js
	 */
	save,
});

const { registerBlockType }  = wp.blocks;
const { Fragment } = wp.element;

registerBlockType( 'gutenberg-block/mcqapp2', {
		title: 'Quiz Two',
		description: 'About your Gutenberg Block',      
		category: 'none',
		
		icon: {
			background: '#0073aa',
			foreground: '#ffffff',
			src: 'excerpt-view',
		},  
				
		edit() {
			return(
				<Fragment>
					<h2>Your Code</h2>
				</Fragment>
			);
		},
		save() {
			return(
				<h4>Your Code</h4>
			);
		},
    }
);