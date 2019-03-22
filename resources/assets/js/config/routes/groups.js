import List from './../../components/Modules/Group/List';
import Edit from './../../components/Modules/Group/Edit';

export default [
	{
		path: 'grupos',
		component: List
    },
    {
		path: 'grupos/adicionar',
		component: Edit
    },
];